<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
  balance: Array,
  auth: Object,
  flash: String
});

const showModal = ref(false);
const modalType = ref('');
const flashMessage = ref(props.flash || null);

const transferEmail = ref('');
const transferAmount = ref('');

flashMessage.value = props.flash || null;

const openModal = (type) => {
    modalType.value = type;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const form = useForm({
    type: '',
    amount: 0,
    email: '',
});

watch(() => props.flash, (newFlash) => {
    flashMessage.value = newFlash || null;
});

const submitTransaction = () => {
    form.post(route('balance.store'), {
        onSuccess: () => {
            closeModal();
        },
    });
};

const handleFormSubmit = () => {
    form.type = modalType.value === 'Entrada' ? 'I' : (modalType.value === 'Saída' ? 'O' : 'T');
    form.amount = transferAmount.value;
    form.email = modalType.value === 'Transferência' ? transferEmail.value : '';

    submitTransaction();
};

</script>

<template>
    <Head title="Saldo" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saldo</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

                <div v-if="flashMessage" class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ flashMessage }}
                </div>

                <div class="flex justify-end space-x-4">
                    <button 
                        @click="openModal('Entrada')" 
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">
                        Entrada
                    </button>
                    <button 
                        @click="openModal('Saída')" 
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200">
                        Saída
                    </button>
                    <button 
                        @click="openModal('Transferência')" 
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition duration-200">
                        Transferência
                    </button>
                </div>

                <div class="bg-blue-500 text-white shadow-lg sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold">{{ auth.user.name }}</h3>
                            <p class="mt-2 text-2xl">Saldo Atual: R$ {{ balance[0].amount || '0,00' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold mb-4">
                    {{ modalType === 'Entrada' ? 'Registrar Entrada de Saldo' : (modalType === 'Saída' ? 'Registrar Saída' : 'Realizar Transferência') }}
                </h3>

                <form @submit.prevent="handleFormSubmit">
                    <div v-if="modalType === 'Transferência'" class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            E-mail do Destinatário
                        </label>
                        <input type="email" v-model="transferEmail" placeholder="exemplo@dominio.com" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Quantia
                        </label>
                        <input type="text" v-model="transferAmount" placeholder="R$ 0,00" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required />
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Cancelar</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            {{ modalType === 'Transferência' ? 'Transferir' : 'Salvar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
