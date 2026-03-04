# Blog Module API Documentation

## Overview

The Blog Module provides RESTful API endpoints for managing blog content. The API is designed to be consumed by both the frontend and potential external applications.

## Base URL

```
https://yourdomain.com/api/blog
```

## Authentication

### Public Endpoints

No authentication required.

### Admin Endpoints

Admin endpoints require authentication via Bearer token. Include the token in the request header:

```
Authorization: Bearer YOUR_ACCESS_TOKEN
```

## Public API Endpoints

### 1. Get All Posts

**GET** `/api/blog/posts`

Query Parameters:
| Parameter | Type | Description | Default |
|-----------|------|-------------|---------|
| page | integer | Page number | 1 |
| limit | integer | Number of posts per page (max 100) | 10 |

**Response:**

```json
{
  "success": true,
  "data": {
    "posts": [
      {
        "id": 1,
        "title": "Blog Post Title",
        "slug": "blog-post-title",
        "excerpt": "Post excerpt...",
        "content": "Full content...",
        "featured_image": "https://example.com/image.jpg",
        "author_name": "Admin",
        "category_name": "Education",
        "category_slug": "education",
        "reading_time": 5,
        "view_count": 150,
        "is_published": true,
        "is_featured": false,
        "published_at": "2026-03-01T10:00:00Z",
        "created_at": "2026-03-01T10:00:00Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "total_pages": 5,
      "total_items": 50,
      "per_page": 10,
      "has_more": true
    }
  }
}
```

### 2. Get Single Post

**GET** `/api/blog/posts/{slug}`

**Response:**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Blog Post Title",
    "slug": "blog-post-title",
    "excerpt": "Post excerpt...",
    "content": "Full HTML content...",
    "featured_image": "https://example.com/image.jpg",
    "author_id": 1,
    "author_name": "Admin",
    "author_email": "admin@example.com",
    "category_id": 1,
    "category_name": "Education",
    "category_slug": "education",
    "meta_title": "SEO Title",
    "meta_description": "SEO Description",
    "meta_keywords": "keyword1, keyword2",
    "reading_time": 5,
    "view_count": 150,
    "is_published": true,
    "is_featured": false,
    "ai_summary": "AI generated summary...",
    "ai_keywords": "keyword1, keyword2",
    "tags": [{ "id": 1, "name": "Tutorial", "slug": "tutorial" }],
    "published_at": "2026-03-01T10:00:00Z",
    "created_at": "2026-03-01T10:00:00Z",
    "updated_at": "2026-03-01T10:00:00Z"
  }
}
```

### 3. Get Featured Posts

**GET** `/api/blog/posts/featured`

Query Parameters:
| Parameter | Type | Description | Default |
|-----------|------|-------------|---------|
| limit | integer | Number of posts | 5 |

### 4. Get All Categories

**GET** `/api/blog/categories`

**Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Education",
      "slug": "education",
      "description": "Education related articles",
      "image": "https://example.com/category.jpg",
      "parent_id": null,
      "display_order": 1,
      "is_active": true,
      "post_count": 10
    }
  ]
}
```

### 5. Get Category with Posts

**GET** `/api/blog/categories/{slug}`

### 6. Get All Tags

**GET** `/api/blog/tags`

### 7. Get Tag with Posts

**GET** `/api/blog/tags/{slug}`

### 8. Search Posts

**GET** `/api/blog/search`

Query Parameters:
| Parameter | Type | Description |
|-----------|------|-------------|
| q | string | Search keyword (required) |
| page | integer | Page number |
| limit | number of posts | |

### 9. Get Sitemap Data

**GET** `/api/blog/sitemap`

## Admin API Endpoints

### Authentication

All admin endpoints require a valid Bearer token. See `AuthApiController` in the main app for authentication.

### 1. Get All Posts (Admin)

**GET** `/api/admin/blog/posts`

Includes draft posts. Query parameters same as public endpoint.

### 2. Create Post

**POST** `/api/admin/blog/posts`

Request Body:

```json
{
  "title": "Post Title",
  "slug": "post-slug",
  "content": "<p>Full HTML content</p>",
  "excerpt": "Short excerpt",
  "featured_image": "https://example.com/image.jpg",
  "category_id": 1,
  "tags": [1, 2, 3],
  "meta_title": "SEO Title",
  "meta_description": "SEO Description",
  "meta_keywords": "keyword1, keyword2",
  "is_published": true,
  "is_featured": false,
  "published_at": "2026-03-01T10:00:00"
}
```

### 3. Get Post by ID

**GET** `/api/admin/blog/posts/{id}`

### 4. Update Post

**PUT** `/api/admin/blog/posts/{id}`

Same request body as create.

### 5. Delete Post

**DELETE** `/api/admin/blog/posts/{id}`

### 6. Toggle Publish Status

**POST** `/api/admin/blog/posts/{id}/toggle`

### 7. Toggle Featured Status

**POST** `/api/admin/blog/posts/{id}/feature`

### 8. Categories CRUD

| Method | Endpoint                          | Description     |
| ------ | --------------------------------- | --------------- |
| GET    | `/api/admin/blog/categories`      | List categories |
| POST   | `/api/admin/blog/categories`      | Create category |
| PUT    | `/api/admin/blog/categories/{id}` | Update category |
| DELETE | `/api/admin/blog/categories/{id}` | Delete category |

### 9. Tags CRUD

| Method | Endpoint                    | Description |
| ------ | --------------------------- | ----------- |
| GET    | `/api/admin/blog/tags`      | List tags   |
| POST   | `/api/admin/blog/tags`      | Create tag  |
| DELETE | `/api/admin/blog/tags/{id}` | Delete tag  |

### 10. AI Features

**POST** `/api/admin/blog/ai/generate-summary`

- Request: `content` (string)
- Response: `{ "success": true, "data": { "summary": "..." } }`

**POST** `/api/admin/blog/ai/extract-keywords`

- Request: `content` (string)
- Response: `{ "success": true, "data": { "keywords": "keyword1, keyword2" } }`

### 11. Statistics

**GET** `/api/admin/blog/stats`

**Response:**

```json
{
  "success": true,
  "data": {
    "total_posts": 50,
    "published_posts": 45,
    "draft_posts": 5,
    "featured_posts": 10,
    "total_views": 15000
  }
}
```

## Error Responses

### 400 Bad Request

```json
{
  "success": false,
  "message": "Validation error message",
  "errors": {
    "field": "Error message"
  }
}
```

### 401 Unauthorized

```json
{
  "success": false,
  "message": "Unauthorized"
}
```

### 404 Not Found

```json
{
  "success": false,
  "message": "Resource not found"
}
```

### 500 Server Error

```json
{
  "success": false,
  "message": "Server error message"
}
```

## Rate Limiting

API requests are limited to 60 requests per minute per IP address.

## Code Examples

### JavaScript/Fetch

```javascript
// Get all posts
const response = await fetch("/api/blog/posts?page=1&limit=10");
const data = await response.json();

// Get single post
const post = await fetch("/api/blog/posts/my-post-slug");
const postData = await post.json();

// Create post (admin)
const createResponse = await fetch("/api/admin/blog/posts", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    Authorization: "Bearer YOUR_TOKEN",
  },
  body: JSON.stringify({
    title: "New Post",
    content: "<p>Content</p>",
    is_published: true,
  }),
});
```

### cURL

```bash
# Get all posts
curl -X GET "https://yourdomain.com/api/blog/posts"

# Create post (admin)
curl -X POST "https://yourdomain.com/api/admin/blog/posts" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"title":"New Post","content":"<p>Content</p>","is_published":true}'
```
