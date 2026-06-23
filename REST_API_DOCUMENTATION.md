# Safari Tour Management System - REST API Documentation

## 1. API Overview

### 1.1 Base URL
```
Development: http://localhost:8000/api/v1
Production: https://api.safaritours.com/api/v1
```

### 1.2 Authentication
The API uses Laravel Sanctum for token-based authentication.

#### Authentication Flow
1. User registers/logs in to receive API token
2. Include token in Authorization header: `Bearer {token}`
3. Token expires after configurable time (default: 1 hour)
4. Refresh token functionality available

#### Response Format
All API responses follow this structure:

**Success Response:**
```json
{
    "success": true,
    "message": "Success message",
    "data": { }
}
```

**Error Response:**
```json
{
    "success": false,
    "message": "Error message",
    "errors": { }
}
```

### 1.3 HTTP Status Codes
- `200 OK` - Request succeeded
- `201 Created` - Resource created successfully
- `400 Bad Request` - Invalid request data
- `401 Unauthorized` - Authentication required
- `403 Forbidden` - Insufficient permissions
- `404 Not Found` - Resource not found
- `422 Unprocessable Entity` - Validation errors
- `429 Too Many Requests` - Rate limit exceeded
- `500 Internal Server Error` - Server error

### 1.4 Rate Limiting
- **Authenticated Users**: 100 requests per minute
- **Unauthenticated Users**: 60 requests per minute
- **IP-based Rate Limiting**: Implemented per endpoint

## 2. Authentication Endpoints

### 2.1 Register User
Create a new user account.

**Endpoint:** `POST /api/v1/auth/register`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "SecurePassword123!",
    "password_confirmation": "SecurePassword123!",
    "phone": "+254700000000",
    "country": "Kenya"
}
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "User registered successfully. Please check your email to verify your account.",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+254700000000",
            "country": "Kenya",
            "email_verified_at": null,
            "created_at": "2024-01-01T10:00:00.000000Z",
            "updated_at": "2024-01-01T10:00:00.000000Z"
        },
        "token": "1|abcdef1234567890..."
    }
}
```

**Validation Errors (422):**
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email has already been taken."
        ],
        "password": [
            "The password must be at least 8 characters."
        ]
    }
}
```

### 2.2 Login User
Authenticate and receive API token.

**Endpoint:** `POST /api/v1/auth/login`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "SecurePassword123!",
    "remember": false
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+254700000000",
            "country": "Kenya",
            "roles": ["customer"],
            "permissions": ["enquiries.create"]
        },
        "token": "1|abcdef1234567890...",
        "token_type": "Bearer",
        "expires_in": 3600
    }
}
```

### 2.3 Logout User
Invalidate current API token.

**Endpoint:** `POST /api/v1/auth/logout`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

### 2.4 Get Current User
Get authenticated user details.

**Endpoint:** `GET /api/v1/auth/user`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+254700000000",
        "country": "Kenya",
        "roles": ["customer"],
        "permissions": ["enquiries.create"],
        "created_at": "2024-01-01T10:00:00.000000Z"
    }
}
```

### 2.5 Refresh Token
Refresh expired API token.

**Endpoint:** `POST /api/v1/auth/refresh`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Token refreshed successfully",
    "data": {
        "token": "2|newtoken1234567890...",
        "token_type": "Bearer",
        "expires_in": 3600
    }
}
```

## 3. User Management Endpoints

### 3.1 Get All Users
Retrieve paginated list of users (Admin only).

**Endpoint:** `GET /api/v1/users`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Query Parameters:**
- `page` (integer, optional) - Page number (default: 1)
- `per_page` (integer, optional) - Items per page (default: 15)
- `search` (string, optional) - Search by name or email
- `role` (string, optional) - Filter by role
- `status` (string, optional) - Filter by status (active, inactive)

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "users": [
            {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com",
                "phone": "+254700000000",
                "country": "Kenya",
                "roles": ["customer"],
                "email_verified_at": "2024-01-01T10:00:00.000000Z",
                "created_at": "2024-01-01T10:00:00.000000Z"
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 15,
            "total": 100,
            "last_page": 7
        }
    }
}
```

### 3.2 Get User by ID
Retrieve specific user details (Admin only).

**Endpoint:** `GET /api/v1/users/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+254700000000",
        "country": "Kenya",
        "roles": ["customer"],
        "permissions": ["enquiries.create"],
        "enquiries_count": 5,
        "last_login": "2024-01-15T10:00:00.000000Z",
        "created_at": "2024-01-01T10:00:00.000000Z",
        "updated_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 3.3 Create User
Create new user (Admin only).

**Endpoint:** `POST /api/v1/users`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "password": "SecurePassword123!",
    "password_confirmation": "SecurePassword123!",
    "phone": "+254700000001",
    "country": "Kenya",
    "role": "sales_agent",
    "permissions": ["enquiries.view", "enquiries.edit"]
}
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "User created successfully",
    "data": {
        "id": 2,
        "name": "Jane Smith",
        "email": "jane@example.com",
        "phone": "+254700000001",
        "country": "Kenya",
        "roles": ["sales_agent"],
        "permissions": ["enquiries.view", "enquiries.edit"],
        "created_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 3.4 Update User
Update user details (Admin only).

**Endpoint:** `PUT /api/v1/users/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "name": "Jane Smith Updated",
    "phone": "+254700000002",
    "country": "Uganda"
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "User updated successfully",
    "data": {
        "id": 2,
        "name": "Jane Smith Updated",
        "email": "jane@example.com",
        "phone": "+254700000002",
        "country": "Uganda",
        "roles": ["sales_agent"],
        "updated_at": "2024-01-15T11:00:00.000000Z"
    }
}
```

### 3.5 Delete User
Delete user (Super Admin only).

**Endpoint:** `DELETE /api/v1/users/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "User deleted successfully"
}
```

### 3.6 Assign Role to User
Assign role to user (Admin only).

**Endpoint:** `POST /api/v1/users/{id}/assign-role`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "role": "admin"
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Role assigned successfully",
    "data": {
        "roles": ["admin"]
    }
}
```

## 4. Enquiry Endpoints

### 4.1 Create Enquiry
Submit new safari enquiry (Public).

**Endpoint:** `POST /api/v1/enquiries`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
    "full_name": "John Doe",
    "email": "john@example.com",
    "phone": "+254700000000",
    "country": "Kenya",
    "package_id": 1,
    "adults": 2,
    "children": 1,
    "travel_date": "2024-06-15",
    "duration": 7,
    "budget": "2000-3000",
    "message": "I am interested in this safari package."
}
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "Enquiry submitted successfully. We will contact you shortly.",
    "data": {
        "id": 1,
        "full_name": "John Doe",
        "email": "john@example.com",
        "phone": "+254700000000",
        "country": "Kenya",
        "package": {
            "id": 1,
            "title": "7-Day Masai Mara Safari",
            "slug": "7-day-masai-mara-safari",
            "price": 2500.00
        },
        "adults": 2,
        "children": 1,
        "travel_date": "2024-06-15",
        "duration": 7,
        "budget": "2000-3000",
        "status": "new",
        "created_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 4.2 Get All Enquiries
Retrieve paginated list of enquiries (Admin/Sales Agent only).

**Endpoint:** `GET /api/v1/enquiries`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Query Parameters:**
- `page` (integer, optional) - Page number (default: 1)
- `per_page` (integer, optional) - Items per page (default: 20)
- `status` (string, optional) - Filter by status
- `assigned_to` (integer, optional) - Filter by assigned agent
- `package_id` (integer, optional) - Filter by package
- `date_from` (date, optional) - Filter from date
- `date_to` (date, optional) - Filter to date
- `search` (string, optional) - Search by name, email, phone

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "enquiries": [
            {
                "id": 1,
                "full_name": "John Doe",
                "email": "john@example.com",
                "phone": "+254700000000",
                "country": "Kenya",
                "package": {
                    "id": 1,
                    "title": "7-Day Masai Mara Safari"
                },
                "assigned_to": {
                    "id": 2,
                    "name": "Jane Smith"
                },
                "adults": 2,
                "children": 1,
                "travel_date": "2024-06-15",
                "status": "new",
                "created_at": "2024-01-15T10:00:00.000000Z"
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 20,
            "total": 50,
            "last_page": 3
        }
    }
}
```

### 4.3 Get Enquiry by ID
Retrieve specific enquiry details.

**Endpoint:** `GET /api/v1/enquiries/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "full_name": "John Doe",
        "email": "john@example.com",
        "phone": "+254700000000",
        "country": "Kenya",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "assigned_to": {
            "id": 2,
            "name": "Jane Smith",
            "email": "jane@example.com"
        },
        "package": {
            "id": 1,
            "title": "7-Day Masai Mara Safari",
            "slug": "7-day-masai-mara-safari",
            "price": 2500.00,
            "duration": 7
        },
        "adults": 2,
        "children": 1,
        "travel_date": "2024-06-15",
        "duration": 7,
        "budget": "2000-3000",
        "message": "I am interested in this safari package.",
        "status": "new",
        "last_contacted_at": null,
        "notes": [],
        "status_history": [
            {
                "status": "new",
                "changed_by": "System",
                "changed_at": "2024-01-15T10:00:00.000000Z"
            }
        ],
        "created_at": "2024-01-15T10:00:00.000000Z",
        "updated_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 4.4 Update Enquiry
Update enquiry details.

**Endpoint:** `PUT /api/v1/enquiries/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "adults": 3,
    "children": 0,
    "travel_date": "2024-07-01",
    "message": "Updated travel dates and group size."
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Enquiry updated successfully",
    "data": {
        "id": 1,
        "adults": 3,
        "children": 0,
        "travel_date": "2024-07-01",
        "message": "Updated travel dates and group size.",
        "updated_at": "2024-01-15T11:00:00.000000Z"
    }
}
```

### 4.5 Assign Enquiry
Assign enquiry to sales agent (Admin only).

**Endpoint:** `POST /api/v1/enquiries/{id}/assign`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "assigned_to": 2
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Enquiry assigned successfully",
    "data": {
        "id": 1,
        "assigned_to": {
            "id": 2,
            "name": "Jane Smith"
        }
    }
}
```

### 4.6 Update Enquiry Status
Update enquiry status.

**Endpoint:** `PUT /api/v1/enquiries/{id}/status`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "status": "contacted",
    "notes": "Initial contact made via phone"
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Enquiry status updated successfully",
    "data": {
        "id": 1,
        "status": "contacted",
        "last_contacted_at": "2024-01-15T11:30:00.000000Z",
        "status_history": [
            {
                "status": "new",
                "changed_by": "System",
                "changed_at": "2024-01-15T10:00:00.000000Z"
            },
            {
                "status": "contacted",
                "changed_by": "Jane Smith",
                "notes": "Initial contact made via phone",
                "changed_at": "2024-01-15T11:30:00.000000Z"
            }
        ]
    }
}
```

### 4.7 Add Enquiry Note
Add internal note to enquiry.

**Endpoint:** `POST /api/v1/enquiries/{id}/notes`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "note": "Customer interested in luxury accommodation options",
    "is_internal": true
}
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "Note added successfully",
    "data": {
        "id": 1,
        "enquiry_id": 1,
        "user": {
            "id": 2,
            "name": "Jane Smith"
        },
        "note": "Customer interested in luxury accommodation options",
        "is_internal": true,
        "created_at": "2024-01-15T12:00:00.000000Z"
    }
}
```

### 4.8 Set Follow-up Reminder
Set follow-up reminder for enquiry.

**Endpoint:** `POST /api/v1/enquiries/{id}/reminders`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "reminder_date": "2024-01-20",
    "reminder_time": "10:00",
    "notes": "Follow up on quotation"
}
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "Reminder set successfully",
    "data": {
        "id": 1,
        "enquiry_id": 1,
        "reminder_date": "2024-01-20",
        "reminder_time": "10:00",
        "notes": "Follow up on quotation",
        "status": "pending",
        "created_at": "2024-01-15T12:00:00.000000Z"
    }
}
```

### 4.9 Delete Enquiry
Delete enquiry (Admin only).

**Endpoint:** `DELETE /api/v1/enquiries/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Enquiry deleted successfully"
}
```

## 5. Safari Package Endpoints

### 5.1 Get All Packages
Retrieve paginated list of safari packages (Public).

**Endpoint:** `GET /api/v1/packages`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Query Parameters:**
- `page` (integer, optional) - Page number (default: 1)
- `per_page` (integer, optional) - Items per page (default: 12)
- `destination` (string, optional) - Filter by destination slug
- `category` (integer, optional) - Filter by category ID
- `min_price` (decimal, optional) - Minimum price
- `max_price` (decimal, optional) - Maximum price
- `min_duration` (integer, optional) - Minimum duration
- `max_duration` (integer, optional) - Maximum duration
- `search` (string, optional) - Search in title, description, location
- `sort_by` (string, optional) - Sort field (price, duration, created_at, popularity)
- `sort_order` (string, optional) - Sort direction (asc, desc)

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "packages": [
            {
                "id": 1,
                "title": "7-Day Masai Mara Safari",
                "slug": "7-day-masai-mara-safari",
                "featured_image": "https://example.com/storage/packages/featured/masai-mara.jpg",
                "short_desc": "Experience the magic of the Masai Mara with this 7-day safari adventure.",
                "duration": 7,
                "price": 2500.00,
                "currency": "USD",
                "location": "Masai Mara, Kenya",
                "is_featured": true,
                "category": {
                    "id": 2,
                    "name": "Mid-Range Safaris",
                    "slug": "mid-range-safaris"
                },
                "destinations": [
                    {
                        "id": 1,
                        "name": "Masai Mara",
                        "slug": "masai-mara"
                    }
                ],
                "views_count": 1250,
                "enquiries_count": 45
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 12,
            "total": 36,
            "last_page": 3
        }
    }
}
```

### 5.2 Get Featured Packages
Retrieve featured packages (Public).

**Endpoint:** `GET /api/v1/packages/featured`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Query Parameters:**
- `limit` (integer, optional) - Number of packages to return (default: 6)

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "packages": [
            {
                "id": 1,
                "title": "7-Day Masai Mara Safari",
                "slug": "7-day-masai-mara-safari",
                "featured_image": "https://example.com/storage/packages/featured/masai-mara.jpg",
                "short_desc": "Experience the magic of the Masai Mara.",
                "duration": 7,
                "price": 2500.00,
                "location": "Masai Mara, Kenya"
            }
        ]
    }
}
```

### 5.3 Get Package by Slug
Retrieve specific package details (Public).

**Endpoint:** `GET /api/v1/packages/{slug}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "7-Day Masai Mara Safari",
        "slug": "7-day-masai-mara-safari",
        "featured_image": "https://example.com/storage/packages/featured/masai-mara.jpg",
        "short_desc": "Experience the magic of the Masai Mara with this 7-day safari adventure.",
        "full_desc": "<p>Detailed description of the safari package...</p>",
        "duration": 7,
        "price": 2500.00,
        "currency": "USD",
        "location": "Masai Mara, Kenya",
        "highlights": [
            "Game drives in Masai Mara",
            "Hot air balloon ride",
            "Visit to Maasai village",
            "Luxury accommodation"
        ],
        "inclusions": [
            "Accommodation for 6 nights",
            "All meals",
            "Transport in 4x4 safari vehicle",
            "Professional guide"
        ],
        "exclusions": [
            "International flights",
            "Travel insurance",
            "Personal expenses"
        ],
        "itinerary": [
            {
                "day": 1,
                "title": "Arrival in Nairobi",
                "description": "Transfer to hotel, briefing"
            },
            {
                "day": 2,
                "title": "Drive to Masai Mara",
                "description": "Morning game drive en route"
            }
        ],
        "is_featured": true,
        "category": {
            "id": 2,
            "name": "Mid-Range Safaris",
            "slug": "mid-range-safaris"
        },
        "destinations": [
            {
                "id": 1,
                "name": "Masai Mara",
                "slug": "masai-mara",
                "description": "Famous for the Great Migration"
            }
        ],
        "gallery": [
            {
                "id": 1,
                "image_path": "https://example.com/storage/packages/gallery/image1.jpg",
                "alt_text": "Lions in Masai Mara"
            }
        ],
        "testimonials": [
            {
                "id": 1,
                "client_name": "John Doe",
                "country": "USA",
                "review": "Amazing experience!",
                "rating": 5
            }
        ],
        "views_count": 1250,
        "enquiries_count": 45,
        "meta_title": "7-Day Masai Mara Safari - Best Safari Experience",
        "meta_description": "Experience the best of Masai Mara with our 7-day safari package.",
        "created_at": "2024-01-01T10:00:00.000000Z",
        "updated_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 5.4 Create Package
Create new safari package (Admin/Content Manager only).

**Endpoint:** `POST /api/v1/packages`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "category_id": 2,
    "title": "5-Day Amboseli Safari",
    "slug": "5-day-amboseli-safari",
    "featured_image": "base64_encoded_image_or_url",
    "short_desc": "Experience Amboseli's elephants and Mount Kilimanjaro views.",
    "full_desc": "<p>Detailed description...</p>",
    "duration": 5,
    "price": 1800.00,
    "currency": "USD",
    "location": "Amboseli National Park, Kenya",
    "highlights": ["Elephant viewing", "Mount Kilimanjaro views", "Cultural visits"],
    "inclusions": ["Accommodation", "Meals", "Transport", "Guide"],
    "exclusions": ["Flights", "Insurance", "Personal expenses"],
    "itinerary": [
        {"day": 1, "title": "Arrival", "description": "Transfer to Amboseli"},
        {"day": 2, "title": "Game Drive", "description": "Full day game drive"}
    ],
    "destinations": [2],
    "gallery": ["base64_image1", "base64_image2"],
    "gallery_alt": ["Elephant herd", "Mount Kilimanjaro"],
    "meta_title": "5-Day Amboseli Safari",
    "meta_description": "Amazing Amboseli safari experience",
    "is_published": false
}
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "Package created successfully",
    "data": {
        "id": 2,
        "title": "5-Day Amboseli Safari",
        "slug": "5-day-amboseli-safari",
        "short_desc": "Experience Amboseli's elephants and Mount Kilimanjaro views.",
        "duration": 5,
        "price": 1800.00,
        "is_published": false,
        "created_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 5.5 Update Package
Update safari package (Admin/Content Manager only).

**Endpoint:** `PUT /api/v1/packages/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "title": "5-Day Amboseli Safari Adventure",
    "price": 1950.00,
    "is_published": true
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Package updated successfully",
    "data": {
        "id": 2,
        "title": "5-Day Amboseli Safari Adventure",
        "slug": "5-day-amboseli-safari",
        "price": 1950.00,
        "is_published": true,
        "published_at": "2024-01-15T10:00:00.000000Z",
        "updated_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 5.6 Publish Package
Publish package (Admin/Content Manager only).

**Endpoint:** `POST /api/v1/packages/{id}/publish`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Package published successfully",
    "data": {
        "id": 2,
        "is_published": true,
        "published_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 5.7 Feature Package
Mark package as featured (Admin/Content Manager only).

**Endpoint:** `POST /api/v1/packages/{id}/feature`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "is_featured": true,
    "featured_until": "2024-02-15T23:59:59.000000Z"
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Package featured successfully",
    "data": {
        "id": 2,
        "is_featured": true,
        "featured_until": "2024-02-15T23:59:59.000000Z"
    }
}
```

### 5.8 Delete Package
Delete package (Admin/Content Manager only).

**Endpoint:** `DELETE /api/v1/packages/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Package deleted successfully"
}
```

## 6. Destination Endpoints

### 6.1 Get All Destinations
Retrieve paginated list of destinations (Public).

**Endpoint:** `GET /api/v1/destinations`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Query Parameters:**
- `page` (integer, optional) - Page number (default: 1)
- `per_page` (integer, optional) - Items per page (default: 12)
- `country` (string, optional) - Filter by country
- `search` (string, optional) - Search in name, description

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "destinations": [
            {
                "id": 1,
                "name": "Masai Mara",
                "slug": "masai-mara",
                "description": "Famous for the annual Great Migration of wildebeest.",
                "featured_image": "https://example.com/storage/destinations/masai-mara.jpg",
                "country": "Kenya",
                "region": "Rift Valley",
                "best_time_to_visit": "July to October",
                "is_featured": true,
                "views_count": 2500,
                "packages_count": 15
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 12,
            "total": 24,
            "last_page": 2
        }
    }
}
```

### 6.2 Get Featured Destinations
Retrieve featured destinations (Public).

**Endpoint:** `GET /api/v1/destinations/featured`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Query Parameters:**
- `limit` (integer, optional) - Number of destinations to return (default: 6)

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "destinations": [
            {
                "id": 1,
                "name": "Masai Mara",
                "slug": "masai-mara",
                "featured_image": "https://example.com/storage/destinations/masai-mara.jpg",
                "country": "Kenya"
            }
        ]
    }
}
```

### 6.3 Get Destination by Slug
Retrieve specific destination details (Public).

**Endpoint:** `GET /api/v1/destinations/{slug}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Masai Mara",
        "slug": "masai-mara",
        "description": "Famous for the annual Great Migration of wildebeest, zebra, and gazelle...",
        "featured_image": "https://example.com/storage/destinations/masai-mara.jpg",
        "country": "Kenya",
        "region": "Rift Valley",
        "latitude": -1.5194,
        "longitude": 35.1728,
        "best_time_to_visit": "July to October",
        "wildlife": [
            "Lions",
            "Elephants",
            "Leopards",
            "Cheetahs",
            "Wildebeest",
            "Zebras"
        ],
        "activities": [
            "Game drives",
            "Hot air balloon safaris",
            "Walking safaris",
            "Cultural visits"
        ],
        "gallery": [
            "https://example.com/storage/destinations/gallery/image1.jpg"
        ],
        "is_featured": true,
        "views_count": 2500,
        "packages": [
            {
                "id": 1,
                "title": "7-Day Masai Mara Safari",
                "slug": "7-day-masai-mara-safari",
                "price": 2500.00,
                "duration": 7
            }
        ],
        "meta_title": "Masai Mara National Reserve - Kenya's Premier Safari Destination",
        "meta_description": "Experience the Great Migration in Masai Mara, Kenya's most famous safari destination.",
        "created_at": "2024-01-01T10:00:00.000000Z",
        "updated_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 6.4 Create Destination
Create new destination (Admin/Content Manager only).

**Endpoint:** `POST /api/v1/destinations`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "name": "Serengeti National Park",
    "slug": "serengeti-national-park",
    "description": "Tanzania's oldest and most popular national park.",
    "featured_image": "base64_encoded_image_or_url",
    "country": "Tanzania",
    "region": "Northern Tanzania",
    "latitude": -2.1540,
    "longitude": 34.6857,
    "best_time_to_visit": "June to October",
    "wildlife": ["Lions", "Elephants", "Wildebeest"],
    "activities": ["Game drives", "Walking safaris"],
    "meta_title": "Serengeti National Park",
    "meta_description": "Experience the Serengeti",
    "is_featured": false
}
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "Destination created successfully",
    "data": {
        "id": 2,
        "name": "Serengeti National Park",
        "slug": "serengeti-national-park",
        "created_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 6.5 Update Destination
Update destination (Admin/Content Manager only).

**Endpoint:** `PUT /api/v1/destinations/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "description": "Updated description of Serengeti National Park.",
    "is_featured": true
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Destination updated successfully",
    "data": {
        "id": 2,
        "name": "Serengeti National Park",
        "description": "Updated description of Serengeti National Park.",
        "is_featured": true,
        "updated_at": "2024-01-15T11:00:00.000000Z"
    }
}
```

### 6.6 Delete Destination
Delete destination (Admin/Content Manager only).

**Endpoint:** `DELETE /api/v1/destinations/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Destination deleted successfully"
}
```

## 7. Blog Endpoints

### 7.1 Get All Blog Posts
Retrieve paginated list of blog posts (Public).

**Endpoint:** `GET /api/v1/blog`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Query Parameters:**
- `page` (integer, optional) - Page number (default: 1)
- `per_page` (integer, optional) - Items per page (default: 12)
- `category` (string, optional) - Filter by category slug
- `tag` (string, optional) - Filter by tag slug
- `search` (string, optional) - Search in title, content

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "posts": [
            {
                "id": 1,
                "title": "Top 10 Safari Tips for Beginners",
                "slug": "top-10-safari-tips-beginners",
                "featured_image": "https://example.com/storage/blog/featured/safari-tips.jpg",
                "excerpt": "Essential tips for your first African safari adventure.",
                "author": {
                    "id": 1,
                    "name": "John Doe"
                },
                "category": {
                    "id": 1,
                    "name": "Safari Tips",
                    "slug": "safari-tips"
                },
                "tags": [
                    {
                        "id": 1,
                        "name": "safari",
                        "slug": "safari"
                    }
                ],
                "publish_date": "2024-01-15T10:00:00.000000Z",
                "views_count": 1250,
                "comments_count": 15
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 12,
            "total": 30,
            "last_page": 3
        }
    }
}
```

### 7.2 Get Blog Post by Slug
Retrieve specific blog post details (Public).

**Endpoint:** `GET /api/v1/blog/{slug}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Top 10 Safari Tips for Beginners",
        "slug": "top-10-safari-tips-beginners",
        "featured_image": "https://example.com/storage/blog/featured/safari-tips.jpg",
        "content": "<p>Full blog post content...</p>",
        "excerpt": "Essential tips for your first African safari adventure.",
        "author": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "category": {
            "id": 1,
            "name": "Safari Tips",
            "slug": "safari-tips"
        },
        "tags": [
            {
                "id": 1,
                "name": "safari",
                "slug": "safari"
            }
        ],
        "publish_date": "2024-01-15T10:00:00.000000Z",
        "meta_title": "Top 10 Safari Tips for Beginners",
        "meta_description": "Essential tips for your first African safari adventure.",
        "allow_comments": true,
        "views_count": 1250,
        "comments": [
            {
                "id": 1,
                "user_name": "Jane Smith",
                "comment": "Great article! Very helpful.",
                "created_at": "2024-01-16T10:00:00.000000Z"
            }
        ],
        "created_at": "2024-01-15T10:00:00.000000Z",
        "updated_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 7.3 Create Blog Post
Create new blog post (Admin/Content Manager only).

**Endpoint:** `POST /api/v1/blog`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "category_id": 1,
    "title": "Best Time for Safari in Kenya",
    "slug": "best-time-safari-kenya",
    "featured_image": "base64_encoded_image_or_url",
    "content": "<p>Full blog post content...</p>",
    "excerpt": "Learn about the best times to visit Kenya for safari.",
    "tags": [1, 2],
    "allow_comments": true,
    "publish_date": "2024-01-20T10:00:00.000000Z",
    "meta_title": "Best Time for Safari in Kenya",
    "meta_description": "Guide to the best safari seasons in Kenya.",
    "is_published": true
}
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "Blog post created successfully",
    "data": {
        "id": 2,
        "title": "Best Time for Safari in Kenya",
        "slug": "best-time-safari-kenya",
        "is_published": true,
        "published_at": "2024-01-20T10:00:00.000000Z",
        "created_at": "2024-01-15T10:00:00.000000Z"
    }
}
```

### 7.4 Update Blog Post
Update blog post (Admin/Content Manager only).

**Endpoint:** `PUT /api/v1/blog/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "title": "Best Time for Safari in Kenya - Complete Guide",
    "content": "<p>Updated content...</p>",
    "is_published": true
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Blog post updated successfully",
    "data": {
        "id": 2,
        "title": "Best Time for Safari in Kenya - Complete Guide",
        "slug": "best-time-safari-kenya",
        "updated_at": "2024-01-15T11:00:00.000000Z"
    }
}
```

### 7.5 Delete Blog Post
Delete blog post (Admin/Content Manager only).

**Endpoint:** `DELETE /api/v1/blog/{id}`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Blog post deleted successfully"
}
```

## 8. Dashboard Endpoints

### 8.1 Get Dashboard Statistics
Get dashboard statistics for authenticated user.

**Endpoint:** `GET /api/v1/dashboard/stats`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "total_users": 150,
        "total_enquiries": 450,
        "new_enquiries": 25,
        "confirmed_bookings": 120,
        "total_packages": 36,
        "published_packages": 30,
        "blog_posts": 45,
        "conversion_rate": 26.7,
        "revenue_this_month": 45000.00,
        "enquiries_by_status": {
            "new": 25,
            "contacted": 80,
            "quotation_sent": 120,
            "negotiation": 60,
            "confirmed": 120,
            "cancelled": 45
        },
        "recent_activities": [
            {
                "action": "enquiry.created",
                "description": "New enquiry from John Doe",
                "created_at": "2024-01-15T10:00:00.000000Z"
            }
        ]
    }
}
```

### 8.2 Get Recent Activities
Get recent activities for authenticated user.

**Endpoint:** `GET /api/v1/dashboard/recent`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Query Parameters:**
- `limit` (integer, optional) - Number of activities to return (default: 10)

**Response (200 OK):**
```json
{
    "success": true,
    "data": {
        "activities": [
            {
                "id": 1,
                "action": "enquiry.status_changed",
                "description": "Enquiry #123 status changed to 'contacted'",
                "ip_address": "192.168.1.1",
                "user_agent": "Mozilla/5.0...",
                "created_at": "2024-01-15T10:00:00.000000Z"
            }
        ]
    }
}
```

## 9. Export Endpoints

### 9.1 Export Enquiries to Excel
Export enquiries to Excel format (Admin only).

**Endpoint:** `GET /api/v1/enquiries/export/excel`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Query Parameters:**
- `status` (string, optional) - Filter by status
- `date_from` (date, optional) - Filter from date
- `date_to` (date, optional) - Filter to date

**Response (200 OK):**
Returns Excel file download

### 9.2 Export Enquiries to PDF
Export enquiries to PDF format (Admin only).

**Endpoint:** `GET /api/v1/enquiries/export/pdf`

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Query Parameters:**
- `status` (string, optional) - Filter by status
- `date_from` (date, optional) - Filter from date
- `date_to` (date, optional) - Filter to date

**Response (200 OK):**
Returns PDF file download

## 10. Error Responses

### 10.1 Authentication Error
```json
{
    "success": false,
    "message": "Unauthenticated.",
    "error": "Your session has expired. Please login again."
}
```

### 10.2 Authorization Error
```json
{
    "success": false,
    "message": "This action is unauthorized.",
    "error": "You do not have permission to perform this action."
}
```

### 10.3 Validation Error
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required.",
            "The email must be a valid email address."
        ],
        "password": [
            "The password must be at least 8 characters."
        ]
    }
}
```

### 10.4 Not Found Error
```json
{
    "success": false,
    "message": "Resource not found",
    "error": "The requested resource could not be found."
}
```

### 10.5 Server Error
```json
{
    "success": false,
    "message": "Internal server error",
    "error": "An unexpected error occurred. Please try again later."
}
```

## 11. API Testing

### 11.1 Using cURL
```bash
# Login
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# Get packages
curl -X GET http://localhost:8000/api/v1/packages \
  -H "Accept: application/json"

# Create enquiry
curl -X POST http://localhost:8000/api/v1/enquiries \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"full_name":"John Doe","email":"john@example.com","phone":"+254700000000","country":"Kenya"}'
```

### 11.2 Using Postman
1. Import the API collection
2. Set base URL: `http://localhost:8000/api/v1`
3. First, authenticate using `/auth/login`
4. Copy the token from response
5. Add token to Authorization header: `Bearer {token}`
6. Make authenticated requests

This comprehensive API documentation provides all the necessary information for integrating with the Safari Tour Management System REST API.