<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    transactionsToday: Number,
    transactionsTodayValue: Number,
    currentBalance: Number,
    previousBalance: Number,
    totalIncoming: Number,
    totalOutgoing: Number,
    lastTransactions: Array
});

const formatCurrency = (value) => {
    if (!value) return 'R$ 0,00';

    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(value);
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-500 text-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Total de Transações Hoje</h3>
                    <p class="mt-4 text-2xl">{{ props.transactionsToday }} Transações</p>
                    <p class="mt-2 text-sm">Valor Total: {{ formatCurrency(props.transactionsTodayValue) }}</p>
                </div>

                <div class="bg-green-500 text-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Saldo Total Atual</h3>
                    <p class="mt-4 text-2xl">{{ formatCurrency(props.currentBalance) }}</p>
                    <p class="mt-2 text-sm">Total Antes: {{ formatCurrency(props.previousBalance) }}</p>
                </div>

                <div class="bg-red-500 text-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Total de Entradas e Saídas</h3>
                    <p class="mt-4 text-lg">Entradas: <span class="text-green-300">+{{ formatCurrency(props.totalIncoming) }}</span></p>
                    <p class="mt-2 text-lg">Saídas: <span class="text-red-300">-{{ formatCurrency(props.totalOutgoing) }}</span></p>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Últimas 10 Transações</h3>
                    <table class="min-w-full mt-4 bg-white border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b text-left">ID</th>
                                <th class="px-4 py-2 border-b text-left">Tipo</th>
                                <th class="px-4 py-2 border-b text-left">Quantia</th>
                                <th class="px-4 py-2 border-b text-left">Antes</th>
                                <th class="px-4 py-2 border-b text-left">Depois</th>
                                <th class="px-4 py-2 border-b text-left">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="transaction in props.lastTransactions" :key="transaction.id">
                                <td class="px-4 py-2 border-b">{{ transaction.id }}</td>
                                <td class="px-4 py-2 border-b">{{ transaction.type }}</td>
                                <td class="px-4 py-2 border-b" :class="transaction.amount > 0 ? 'text-green-500' : 'text-red-500'">
                                    {{ transaction.amount > 0 ? '+' : '-' }}{{ formatCurrency(transaction.amount) }}
                                </td>
                                <td class="px-4 py-2 border-b">{{ formatCurrency(transaction.total_before) }}</td>
                                <td class="px-4 py-2 border-b">{{ formatCurrency(transaction.total_after) }}</td>
                                <td class="px-4 py-2 border-b">{{ transaction.date }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
