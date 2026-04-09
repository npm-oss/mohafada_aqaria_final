# استخدام صورة PHP 8.1 الرسمية (Alpine لتقليل الحجم)
FROM php:8.1-cli-alpine

# تثبيت ملحقات النظام والأدوات الضرورية
RUN apk add --no-cache \
    unzip \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    sqlite-dev \
    sqlite \
    git

# تثبيت ملحقات PHP اللازمة لـ Laravel و SQLite
RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

# تثبيت Composer من الصورة الرسمية
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تحديد مجلد العمل داخل الحاوية
WORKDIR /app

# نسخ جميع ملفات المشروع إلى الحاوية
COPY . .

# إعداد ملف البيئة والمجلدات وقاعدة البيانات
RUN cp .env.example .env \
    && mkdir -p database \
    && touch database/database.sqlite \
    && mkdir -p storage/framework/{sessions,views,cache} \
    && chmod -R 777 storage bootstrap/cache \
    && composer install --no-dev --optimize-autoloader

# التحضير النهائي
RUN php artisan key:generate --force

# إعداد المتغيرات البيئية الافتراضية
ENV PORT=8080
ENV APP_ENV=production
ENV APP_DEBUG=false
EXPOSE 8080

# تنفيذ الأوامر عند بدء التشغيل
CMD php artisan migrate --force --seed && php artisan serve --host=0.0.0.0 --port=$PORT
