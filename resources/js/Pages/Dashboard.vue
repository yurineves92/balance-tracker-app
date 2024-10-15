<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total de Transações Hoje -->
                <div class="bg-blue-500 text-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Total de Transações Hoje</h3>
                    <p class="mt-4 text-2xl">5 Transações</p> <!-- Exemplo: Número de transações de hoje -->
                    <p class="mt-2 text-sm">Valor Total: R$ 5.230,00</p> <!-- Exemplo: Valor total de transações de hoje -->
                </div>

                <!-- Saldo Total Atual -->
                <div class="bg-green-500 text-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Saldo Total Atual</h3>
                    <p class="mt-4 text-2xl">R$ 32.540,00</p> <!-- Exemplo: Saldo após a última transação -->
                    <p class="mt-2 text-sm">Total Antes: R$ 30.000,00</p> <!-- Exemplo: Saldo antes das transações recentes -->
                </div>

                <!-- Total de Entradas e Saídas -->
                <div class="bg-red-500 text-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Total de Entradas e Saídas</h3>
                    <p class="mt-4 text-lg">Entradas: <span class="text-green-300">+R$ 10.000,00</span></p> <!-- Exemplo: Total de entradas (Incoming) -->
                    <p class="mt-2 text-lg">Saídas: <span class="text-red-300">-R$ 4.500,00</span></p> <!-- Exemplo: Total de saídas (Outgoing) -->
                </div>
            </div>


            <!-- Listagem das 5 Últimas Transações -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Últimas 5 Transações</h3>
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
                            <tr>
                                <td class="px-4 py-2 border-b">1</td>
                                <td class="px-4 py-2 border-b">Entrada</td> <!-- Tipo: Incoming -->
                                <td class="px-4 py-2 border-b text-green-500">+R$ 2.500,00</td>
                                <td class="px-4 py-2 border-b">R$ 30.000,00</td>
                                <td class="px-4 py-2 border-b">R$ 32.500,00</td>
                                <td class="px-4 py-2 border-b">15/10/2024</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 border-b">2</td>
                                <td class="px-4 py-2 border-b">Saída</td> <!-- Tipo: Outgoing -->
                                <td class="px-4 py-2 border-b text-red-500">-R$ 1.000,00</td>
                                <td class="px-4 py-2 border-b">R$ 32.500,00</td>
                                <td class="px-4 py-2 border-b">R$ 31.500,00</td>
                                <td class="px-4 py-2 border-b">14/10/2024</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 border-b">3</td>
                                <td class="px-4 py-2 border-b">Transferência</td> <!-- Tipo: Transfer -->
                                <td class="px-4 py-2 border-b text-blue-500">-R$ 500,00</td>
                                <td class="px-4 py-2 border-b">R$ 31.500,00</td>
                                <td class="px-4 py-2 border-b">R$ 31.000,00</td>
                                <td class="px-4 py-2 border-b">13/10/2024</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 border-b">4</td>
                                <td class="px-4 py-2 border-b">Entrada</td> <!-- Tipo: Incoming -->
                                <td class="px-4 py-2 border-b text-green-500">+R$ 4.000,00</td>
                                <td class="px-4 py-2 border-b">R$ 31.000,00</td>
                                <td class="px-4 py-2 border-b">R$ 35.000,00</td>
                                <td class="px-4 py-2 border-b">12/10/2024</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 border-b">5</td>
                                <td class="px-4 py-2 border-b">Saída</td> <!-- Tipo: Outgoing -->
                                <td class="px-4 py-2 border-b text-red-500">-R$ 3.200,00</td>
                                <td class="px-4 py-2 border-b">R$ 35.000,00</td>
                                <td class="px-4 py-2 border-b">R$ 31.800,00</td>
                                <td class="px-4 py-2 border-b">11/10/2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
