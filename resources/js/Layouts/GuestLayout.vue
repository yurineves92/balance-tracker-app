<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div className="flex items-center justify-center py-4">
            <Link href="/" className="text-center">
                <h1 className="text-3xl font-bold text-gray-800 hover:text-blue-600 transition-colors duration-300">
                    Sistema de Saldo
                </h1>
                <hr className="mt-2 border-gray-300" />
            </Link>
        </div>
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
