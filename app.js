const SUPABASE_URL = 'https://pnisrktkkbzspolkfkag.supabase.co';
const SUPABASE_KEY = 'sb_publishable_ClLcjnxymypzS2O6x1TzwA_c9y7-j1Y';
const headers = { apikey: SUPABASE_KEY, Authorization: `Bearer ${SUPABASE_KEY}` };
const state = { segments: [], categories: [], calculators: [], versions: [], fields: [], formulas: [], activeSegment: 'all' };

async function sb(path) {
  const r = await fetch(`${SUPABASE_URL}/rest/v1/${path}`, { headers });
  if (!r.ok) throw new Error(`${r.status} ${await r.text()}`);
  return r.json();
}

async function loadData() {
  try {
    const [segments,categories,calculators,versions] = await Promise.all([
      sb('segments?select=*&is_active=eq.true&order=sort_order'),
      sb('calculator_categories?select=*&is_active=eq.true&order=sort_order'),
      sb('calculators?select=*&status=eq.published&order=sort_order'),
      sb('calculator_versions?select=*&status=eq.published&order=effective_from.desc.nullslast'),
    ]);
    Object.assign(state,{segments,categories,calculators,versions});
    document.getElementById('segmentCount').textContent = `${segments.length} segmen`;
    document.getElementById('calculatorCount').textContent = `${calculators.length} kalkulator aktif`;
    renderSegments(); renderCalculators();
  } catch (e) {
    document.getElementById('calculatorGrid').innerHTML = `<div class="empty">Database belum bisa dibaca.<br><small>${escapeHtml(e.message)}</small></div>`;
  }
}

function renderSegments(){
  const el=document.getElementById('segmentList');
  el.innerHTML=`<button class="segment-button active" data-segment="all">Semua</button>`+state.segments.map(s=>`<button class="segment-button" data-segment="${s.id}">${escapeHtml(s.name)}</button>`).join('');
  el.querySelectorAll('button').forEach(b=>b.onclick=()=>{state.activeSegment=b.dataset.segment;el.querySelectorAll('button').forEach(x=>x.classList.toggle('active',x===b));document.getElementById('sectionTitle').textContent=state.activeSegment==='all'?'Semua kalkulator':state.segments.find(s=>s.id===state.activeSegment)?.name||'Kalkulator';renderCalculators();});
}

function visibleCalculators(){
  const q=(document.getElementById('searchInput')?.value||'').toLowerCase().trim();
  return state.calculators.filter(c=>{const cat=state.categories.find(x=>x.id===c.category_id);const segmentOK=state.activeSegment==='all'||cat?.segment_id===state.activeSegment;const text=`${c.name} ${c.short_description||''}`.toLowerCase();return segmentOK&&(!q||text.includes(q));});
}

function renderCalculators(){
  const grid=document.getElementById('calculatorGrid'); const list=visibleCalculators();
  if(!list.length){grid.innerHTML='<div class="empty">Belum ada kalkulator di filter ini.</div>';return;}
  grid.innerHTML=list.map(c=>{const cat=state.categories.find(x=>x.id===c.category_id);const seg=state.segments.find(x=>x.id===cat?.segment_id);const version=state.versions.find(v=>v.calculator_id===c.id);return `<article class="card calculator-card" data-id="${c.id}"><div class="card-tag">${escapeHtml(seg?.name||'Banking')} · ${escapeHtml(cat?.name||'')}</div><h3>${escapeHtml(c.name)}</h3><p>${escapeHtml(c.short_description||'Dynamic banking calculator.')}</p><div class="card-bottom"><span><span class="status-dot"></span>Published</span><span>v${escapeHtml(version?.version_no||'—')}</span></div></article>`}).join('');
  grid.querySelectorAll('.calculator-card').forEach(c=>c.onclick=()=>openCalculator(c.dataset.id));
}

async function openCalculator(calculatorId){
  const dialog=document.getElementById('calculatorDialog'); const view=document.getElementById('calculatorView'); const calc=state.calculators.find(c=>c.id===calculatorId); const version=state.versions.find(v=>v.calculator_id===calculatorId);
  if(!version) return;
  view.innerHTML='<div style="padding:50px">Loading calculator…</div>'; dialog.showModal();
  try{
    const [fields,formulas]=await Promise.all([
      sb(`calculator_fields?select=*&calculator_version_id=eq.${version.id}&order=sort_order`),
      sb(`calculator_formulas?select=*&calculator_version_id=eq.${version.id}&order=sort_order`),
    ]);
    view.innerHTML=`<div class="calc-shell"><form id="dynamicForm" class="calc-form"><div class="eyebrow">DYNAMIC CALCULATOR · v${escapeHtml(version.version_no)}</div><h2 class="calc-title">${escapeHtml(calc.name)}</h2><div class="calc-subtitle">${escapeHtml(calc.long_description||calc.short_description||'Masukkan nilai untuk melakukan perhitungan.')}</div>${fields.map(renderField).join('')}<button class="calculate-btn" type="submit">Calculate</button></form><section id="calcResults" class="calc-results"><div class="result-placeholder"><div><div style="font-size:32px;margin-bottom:10px">∑</div>Hasil kalkulasi akan muncul di sini.</div></div></section></div>`;
    const form=document.getElementById('dynamicForm');
    fields.forEach(f=>{const input=form.elements[f.field_key]; if(input && f.default_value!==null && f.default_value!==undefined) input.value=typeof f.default_value==='object'?Object.values(f.default_value)[0]:f.default_value;});
    form.onsubmit=e=>{e.preventDefault();calculate(fields,formulas,form)};
  }catch(e){view.innerHTML=`<div style="padding:40px" class="error-box">${escapeHtml(e.message)}</div>`}
}

function renderField(f){
  const v=f.validation||{}; const min=v.min!==undefined?`min="${v.min}"`:''; const max=v.max!==undefined?`max="${v.max}"`:''; const step=['integer'].includes(f.field_type)?'1':'any';
  let prefix=f.field_type==='currency'?'<span class="field-prefix">Rp</span>':''; let suffix=f.field_type==='percentage'?'<span class="field-suffix">%</span>':(f.unit?`<span class="field-suffix">${escapeHtml(f.unit)}</span>`:'');
  if(f.field_type==='select'){const opts=(f.options||[]).map(o=>typeof o==='object'?`<option value="${escapeHtml(o.value)}">${escapeHtml(o.label||o.value)}</option>`:`<option>${escapeHtml(o)}</option>`).join('');return `<div class="field"><label>${escapeHtml(f.label)}</label><div class="field-wrap"><select name="${escapeHtml(f.field_key)}" ${f.is_required?'required':''}>${opts}</select></div></div>`}
  return `<div class="field"><label>${escapeHtml(f.label)}</label><div class="field-wrap">${prefix}<input name="${escapeHtml(f.field_key)}" type="number" step="${step}" ${min} ${max} ${f.is_required?'required':''} placeholder="${escapeHtml(f.placeholder||'0')}"/>${suffix}</div>${f.description?`<small style="color:#728aa5">${escapeHtml(f.description)}</small>`:''}</div>`;
}

function calculate(fields,formulas,form){
  const ctx={}; for(const f of fields){const val=form.elements[f.field_key]?.value;ctx[f.field_key]=val===''?0:Number(val);}
  const results=[];
  try{
    for(const formula of formulas){
      let value;
      if(formula.formula_key==='monthly_payment' && Number(ctx.monthly_rate)===0){value=Number(ctx.principal)/Number(ctx.months);} else {value=evaluateExpression(formula.expression,ctx);}
      ctx[formula.formula_key]=value; results.push({...formula,value});
    }
    document.getElementById('calcResults').innerHTML=`<div class="result-head">Calculation Result</div>${results.filter(x=>x.is_visible!==false).map(r=>`<div class="result-item"><div class="result-label">${escapeHtml(r.label)}</div><div class="result-value">${formatValue(r.value,r.output_type,r.precision_digits)}</div>${r.explanation_md?`<div class="result-explain">${escapeHtml(r.explanation_md)}</div>`:''}<div class="formula-code">${escapeHtml(r.expression)}</div></div>`).join('')}`;
  }catch(e){document.getElementById('calcResults').innerHTML=`<div class="error-box">Formula error: ${escapeHtml(e.message)}</div>`}
}

// Safe arithmetic parser: + - * / ^, parentheses, numbers, and variables only. No eval/new Function.
function evaluateExpression(expr,context){
  const tokens=tokenize(expr); const output=[]; const ops=[]; const prec={'+':1,'-':1,'*':2,'/':2,'^':3}; const right={'^':true};
  let prev='start';
  for(const t of tokens){
    if(t.type==='number'||t.type==='var'){output.push(t);prev='value';continue;}
    if(t.value==='('){ops.push(t);prev='(';continue;}
    if(t.value===')'){while(ops.length&&ops.at(-1).value!=='(')output.push(ops.pop());if(!ops.length)throw Error('Kurung tidak seimbang');ops.pop();prev='value';continue;}
    if(t.type==='op'){
      if(t.value==='-'&&(prev==='start'||prev==='op'||prev==='(')) output.push({type:'number',value:0});
      while(ops.length&&ops.at(-1).type==='op'&&((right[t.value]?prec[t.value]<prec[ops.at(-1).value]:prec[t.value]<=prec[ops.at(-1).value])))output.push(ops.pop());ops.push(t);prev='op';
    }
  }
  while(ops.length){if(ops.at(-1).value==='(')throw Error('Kurung tidak seimbang');output.push(ops.pop());}
  const stack=[]; for(const t of output){if(t.type==='number')stack.push(Number(t.value));else if(t.type==='var'){if(!(t.value in context))throw Error(`Variable ${t.value} belum tersedia`);stack.push(Number(context[t.value]));}else{const b=stack.pop(),a=stack.pop();if(a===undefined||b===undefined)throw Error('Ekspresi tidak valid');stack.push(({'+':()=>a+b,'-':()=>a-b,'*':()=>a*b,'/':()=>a/b,'^':()=>a**b}[t.value])());}}
  if(stack.length!==1||!Number.isFinite(stack[0]))throw Error('Hasil formula tidak valid'); return stack[0];
}
function tokenize(s){const out=[];let i=0;while(i<s.length){const c=s[i];if(/\s/.test(c)){i++;continue}if(/[0-9.]/.test(c)){let j=i+1;while(j<s.length&&/[0-9.]/.test(s[j]))j++;const v=s.slice(i,j);if((v.match(/\./g)||[]).length>1)throw Error('Angka tidak valid');out.push({type:'number',value:v});i=j;continue}if(/[A-Za-z_]/.test(c)){let j=i+1;while(j<s.length&&/[A-Za-z0-9_]/.test(s[j]))j++;out.push({type:'var',value:s.slice(i,j)});i=j;continue}if('+-*/^()'.includes(c)){out.push({type:'+-*/^'.includes(c)?'op':'paren',value:c});i++;continue}throw Error(`Karakter formula tidak diizinkan: ${c}`)}return out}
function formatValue(v,type,precision=0){const p=precision??0;if(type==='currency')return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:p}).format(v);if(type==='percentage')return `${new Intl.NumberFormat('id-ID',{maximumFractionDigits:p}).format(v)}%`;return new Intl.NumberFormat('id-ID',{maximumFractionDigits:p}).format(v)}
function escapeHtml(s){return String(s??'').replace(/[&<>'"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#039;','"':'&quot;'}[c]))}

document.getElementById('searchInput').addEventListener('input',renderCalculators);document.getElementById('closeDialog').onclick=()=>document.getElementById('calculatorDialog').close();document.getElementById('calculatorDialog').addEventListener('click',e=>{if(e.target===e.currentTarget)e.currentTarget.close()});loadData();
