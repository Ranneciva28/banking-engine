# Banking Engine V2

Static banking calculator website + secure database-driven Admin Console.

## Files
- `index.html` — public calculator directory
- `app.js` — dynamic calculator renderer + safe arithmetic parser
- `admin.html` — Admin V2 interface
- `admin.js` — Supabase Auth, RBAC CRUD, versioning, preview, publish, audit UI
- `styles.css` — shared public/admin styling

## Supabase
Project: `Banking Engine`
Project ref: `pnisrktkkbzspolkfkag`
Region: Singapore (`ap-southeast-1`)

The browser uses a Supabase publishable key. This is intentional and safe only because write operations are protected by RLS. Never put a service-role/secret key in this static website.

## First admin activation
1. Open `admin.html` from a hosted site.
2. Register an account or login with Supabase email/password.
3. If the account has no admin role, the site shows the one-time activation form.
4. Enter the activation code supplied separately with this build.
5. The code is single-use and then disabled.

## Admin V2 features
- Email/password authentication
- One-time ADMIN role activation
- Segment manager
- Category manager
- Calculator creator/editor
- Calculator version selector
- Clone published/latest version into a draft
- Dynamic field builder
- Formula builder with safe-expression validation
- Draft preview
- Publish workflow with effective date
- Automatic retirement of previous effective version
- Database audit trail for admin changes
- Supabase RLS protection

## Current formula engine
Supported arithmetic: `+ - * / ^`, parentheses, numbers, and previously-defined variables.
The browser does not use `eval()` or `new Function()`.

## Deployment
This remains a static site: upload/replace the files on any static host (GitHub Pages, Netlify, Vercel static hosting, etc.). No build command is required.

## Recommended next phase
Admin V3: Parameters + Parameter Versioning UI, Regulations & SOP manager, document upload/storage, calculator-to-regulation linking, assessment rules, richer formula functions/conditions, Maker/Checker/Approver workflow, and calculation history.
