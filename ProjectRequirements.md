## Project Requirements
Personal Blog 

### MVP:
- User types: Author, User
- Author can create post categories
- Author can create posts with title, feature image, other images, video, tags
- Posts would have word count and reading time as well
- A user can comment once logged in
- Comment thread

### Future Scope:
- Newsletter subscription
- Mailing weekly newsletter
- minIO file storage

### Database structure:
- Users
  - Name
  - Email
  - username
  - password
  - role
- Posts
  - Title
  - slug
  - pretext
  - content
  - feature_image
  - Categories
  - Tags
  - Media
  - Author
- Categories
  - Title
  - Description
- Tags
  - Title
  - Description
- Media
  - name
  - type
