# Database Schema

## Tables

### users
| Column | Type | Description |
|--------|------|--------------|
| id | bigint | Primary key |
| name | string | User full name |
| email | string | Unique email |
| email_verified_at | timestamp | Email verification |
| password | string | Hashed password |
| phone | string | Phone number (nullable) |
| role | enum | user, organizer, admin |
| remember_token | string | Remember me token |
| timestamps | timestamps | Created/Updated |

### events
| Column | Type | Description |
|--------|------|--------------|
| id | bigint | Primary key |
| title | string | Event title |
| description | text | Event description |
| date | date | Event date |
| started_at | timestamp | Start time |
| end_at | timestamp | End time (nullable) |
| location | string | Event location |
| image | string | Event image path |
| slug | string | SEO-friendly slug (unique) |
| is_published | boolean | Published status |
| max_attendees | integer | Max attendees (nullable) |
| user_id | bigint | FK → users (organizer) |
| timestamps | timestamps | Created/Updated |

### ticket_types
| Column | Type | Description |
|--------|------|--------------|
| id | bigint | Primary key |
| event_id | bigint | FK → events |
| name | string | Ticket type name |
| description | text | Description (nullable) |
| price | decimal | Ticket price |
| quantity | integer | Total quantity |
| available_quantity | integer | Available (nullable) |
| timestamps | timestamps | Created/Updated |

### bookings
| Column | Type | Description |
|--------|------|--------------|
| id | bigint | Primary key |
| user_id | bigint | FK → users |
| event_id | bigint | FK → events |
| ticket_type_id | bigint | FK → ticket_types |
| quantity | integer | Number of tickets |
| status | enum | pending, paid, cancelled |
| total_price | decimal | Total price (nullable) |
| cancelled_at | timestamp | Cancellation time (nullable) |
| timestamps | timestamps | Created/Updated |

## Relationships

- **User** → hasMany → Events (as organizer)
- **User** → hasMany → Bookings
- **Event** → belongsTo → User
- **Event** → hasMany → TicketTypes
- **Event** → hasMany → Bookings
- **TicketType** → belongsTo → Event
- **TicketType** → hasMany → Bookings
- **Booking** → belongsTo → User
- **Booking** → belongsTo → Event
- **Booking** → belongsTo → TicketType

## Roles

| Role | Description |
|------|-------------|
| user | Can browse and book events |
| organizer | Can create and manage events |
| admin | Full platform access |