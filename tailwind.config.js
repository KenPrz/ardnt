import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                customSerif:['Libre Baskerville', 'serif'],
                customSans:['Open Sans', 'sans-serif'],
            },
            colors: {
                maroon: {
                    100: "#ecd3d6",
                    200: "#d9a7ae",
                    300: "#c67b85",
                    400: "#b34f5d",
                    500: "#a02334",
                    600: "#801c2a",
                    700: "#60151f",
                    800: "#400e15",
                    900: "#20070a",
                },
                orange: {
                    100: "#ffefdf",
                    200: "#ffdebf",
                    300: "#ffcea0",
                    400: "#ffbd80",
                    500: "#ffad60",
                    600: "#cc8a4d",
                    700: "#99683a",
                    800: "#664526",
                    900: "#332313",
                },
                yellow: {
                    100: "#fffcef",
                    200: "#fff8de",
                    300: "#fff5ce",
                    400: "#fff1bd",
                    500: "#ffeead",
                    600: "#ccbe8a",
                    700: "#998f68",
                    800: "#665f45",
                    900: "#333023",
                },
                green: {
                    100: "#eaf5f0",
                    200: "#d5ebe1",
                    300: "#c0e2d2",
                    400: "#abd8c3",
                    500: "#96ceb4",
                    600: "#78a590",
                    700: "#5a7c6c",
                    800: "#3c5248",
                    900: "#1e2924"
                },
            },
        },
    },

    plugins: [forms],
};
