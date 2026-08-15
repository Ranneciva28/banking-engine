# Banking Engine V1

Static, database-driven banking calculator UI connected to Supabase project `Banking Engine`.

## What works now
- Segment navigation loaded from Supabase
- Calculator library loaded from Supabase
- Dynamic calculator fields loaded per calculator version
- Dynamic formulas loaded per calculator version
- Safe arithmetic expression parser (no `eval` / `new Function`)
- Deposito Berjangka and Angsuran Anuitas demo calculators
- Zero-interest fallback for annuity demo
- Read-only Admin dashboard with live database counts
- Responsive dark UI

## Deploy
This folder is static and can be uploaded directly to GitHub Pages, Netlify, Cloudflare Pages, or Vercel.

No build command is required. Entry file: `index.html`.

## Security
The Supabase publishable key is intentionally safe to place in frontend code. Actual access is controlled by PostgreSQL grants and RLS. Do not put a service-role/secret key in these files.

Admin write operations are intentionally not implemented in V1 frontend until Auth + admin authorization + audit policies are configured.

## Formula syntax currently supported
Numbers, variables, parentheses, and operators: `+ - * / ^`.

Example:
`principal * (annual_rate / 100) * days / 365`

Future engine versions can add controlled functions (MIN/MAX/ROUND/IF) without using arbitrary JavaScript evaluation.
