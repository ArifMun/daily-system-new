module.exports = {
    proxy: "http://127.0.0.1:8000", // Mengarah ke server php artisan serve Anda
    navigate: true,
    watch: ["resources/views/**/*.blade.php", "public/**/*"], // Memantau perubahan file HTML/Blade dan CSS/JS
};
