import os
import dj_database_url

# Thêm vào phần ALLOWED_HOSTS
ALLOWED_HOSTS = ['*']

# Cập nhật cấu hình database
DATABASES = {
    'default': dj_database_url.config(
        default=os.environ.get('DATABASE_URL')
    )
}

# Cấu hình static files
STATIC_ROOT = os.path.join(BASE_DIR, 'staticfiles')
STATIC_URL = '/static/'

# Thêm whitenoise middleware
MIDDLEWARE = [
    # ...
    'whitenoise.middleware.WhiteNoiseMiddleware',
    # ...
]

# Cấu hình static files
STATICFILES_STORAGE = 'whitenoise.storage.CompressedManifestStaticFilesStorage' 