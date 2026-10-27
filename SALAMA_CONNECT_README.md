# Salama Connect

Digital service platform for **Salama Children’s Home (SOVc)**, Bagamoyo, Tanzania.

People-first platform: find support, request help, join programmes, donate and volunteer.

## Status (October 2026 foundation)

### Completed
1. **All public Blade views**
   - Homepage (people-first CTAs)
   - Find Support directory + facility detail (with Leaflet map)
   - Programs listing + detail
   - Confidential support request form + thank-you
   - Donate form + thank-you
   - Volunteer application + thank-you
   - About, Contact, Privacy pages

2. **Basic Admin Dashboard** (`/admin`)
   - Overview metrics
   - Recent support requests table
   - Ready to expand into full CRUD

3. **Database seeders**
   - Salama Children’s Home as primary facility (with real contact details & approximate coordinates)
   - Three core programmes: Kindergarten, Mechanics, Tailoring

4. **Leaflet map integration**
   - OpenStreetMap tiles
   - Markers for facilities that have coordinates
   - Centered on Bagamoyo

5. **Multi-language support (EN + SW)**
   - Language files in `lang/en` and `lang/sw`
   - Language switcher in the header
   - Session-based locale
   - Key UI strings translated

## Quick Start

```bash
cd salama-connect

composer install          # required – vendor may be incomplete in some environments
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Then open:
- Public site: http://127.0.0.1:8000
- Admin overview: http://127.0.0.1:8000/admin

## Key routes

| URL | Purpose |
|-----|---------|
| `/` | Homepage |
| `/find-support` | Directory + map |
| `/programs` | Programmes |
| `/request-help` | Confidential support form |
| `/donate` | Donation intention |
| `/volunteer` | Volunteer application |
| `/admin` | Simple dashboard |
| `/lang/en` or `/lang/sw` | Switch language |

## Next recommended work

- Protect `/admin` with authentication (Laravel Breeze or Fortify)
- Full Filament or custom CRUD for facilities, programmes, requests
- Real mobile-money payment gateway
- Email notifications for new support requests
- More complete Swahili translations
- Role-based permissions
- Photo uploads for programmes

## Contact (from original site)

- Phone: +255 688 489 495
- Email: info@salamachildrens.or.tz
- Location: Bagamoyo (Kiharaka), Tanzania

---
Built as a practical, expandable foundation for Salama Connect.

## Updates (Admin CRUD + Pesapal)

### Admin CRUD
- **Programs**: full create / edit / delete at `/admin/programs`
- **Children at centre**: full CRUD at `/admin/children`
  - Fields: name, age/DOB, gender, linked program, guardian, status, notes, admission date
- Dashboard shows active children count and recent donations

### Pesapal payment flow
1. Donor selects **Pesapal** on the donate form
2. System creates a Donation record + calls Pesapal `SubmitOrderRequest`
3. User is redirected to Pesapal hosted checkout (M-Pesa, Tigo Pesa, cards, etc.)
4. After payment, Pesapal redirects to `/donate/pesapal/callback`
5. Pesapal also sends IPN to `/donate/pesapal/ipn`
6. Both endpoints call `GetTransactionStatus` and update the local donation

### Pesapal setup (.env)
```
PESAPAL_CONSUMER_KEY=your_key
PESAPAL_CONSUMER_SECRET=your_secret
PESAPAL_LIVE=false
PESAPAL_NOTIFICATION_ID=   # from RegisterIPN response
```

Register your IPN once (e.g. via tinker or a one-off command) pointing to:
`https://your-domain.com/donate/pesapal/ipn`

Then store the returned `notification_id` in `PESAPAL_NOTIFICATION_ID`.
