<script setup></script>

<template>
    <div
        v-if="$page.props.flash.status === 'success'"
        class="p-4 px-2 py-1 text-white bg-blue-400 rounded shadow-lg"
    >
        {{ $page.props.flash.message }}
    </div>

    <div
        v-if="$page.props.flash.status === 'danger'"
        class="p-4 px-2 py-1 text-white bg-red-400 rounded shadow-lg"
    >
        {{ $page.props.flash.message }}
    </div>
</template>
