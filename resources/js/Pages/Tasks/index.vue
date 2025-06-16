<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

import { usePage } from '@inertiajs/vue3'
const page = usePage()

const invoices = [
    {
        invoice: 'INV001',
        paymentStatus: 'Paid',
        totalAmount: '$250.00',
        paymentMethod: 'Credit Card',
    },
    {
        invoice: 'INV002',
        paymentStatus: 'Pending',
        totalAmount: '$150.00',
        paymentMethod: 'PayPal',
    },
    {
        invoice: 'INV003',
        paymentStatus: 'Unpaid',
        totalAmount: '$350.00',
        paymentMethod: 'Bank Transfer',
    },
    {
        invoice: 'INV004',
        paymentStatus: 'Paid',
        totalAmount: '$450.00',
        paymentMethod: 'Credit Card',
    },
    {
        invoice: 'INV005',
        paymentStatus: 'Paid',
        totalAmount: '$550.00',
        paymentMethod: 'PayPal',
    },
    {
        invoice: 'INV006',
        paymentStatus: 'Pending',
        totalAmount: '$200.00',
        paymentMethod: 'Bank Transfer',
    },
    {
        invoice: 'INV007',
        paymentStatus: 'Unpaid',
        totalAmount: '$300.00',
        paymentMethod: 'Credit Card',
    },
]
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">📝 Lista de Tareas</h1>

        <Table class="w-full border rounded-xl shadow-sm overflow-hidden">
            <TableCaption class="p-4 text-gray-500">Una lista de tus facturas recientes</TableCaption>

            <TableHeader class="bg-gray-100">
                <TableRow>
                    <TableHead class="w-[120px] px-4 py-2">Factura</TableHead>
                    <TableHead class="px-4 py-2">Estado</TableHead>
                    <TableHead class="px-4 py-2">Método</TableHead>
                    <TableHead class="px-4 py-2 text-right">Monto</TableHead>
                </TableRow>
            </TableHeader>

            <TableBody>
                <TableRow v-for="invoice in invoices" :key="invoice.invoice" class="hover:bg-gray-50 transition-colors">
                    <TableCell class="font-medium px-4 py-2">
                        {{ invoice.invoice }}
                    </TableCell>
                    <TableCell class="px-4 py-2">{{ invoice.paymentStatus }}</TableCell>
                    <TableCell class="px-4 py-2">{{ invoice.paymentMethod }}</TableCell>
                    <TableCell class="px-4 py-2 text-right">
                        {{ invoice.totalAmount }}
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
