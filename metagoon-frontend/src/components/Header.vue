<template>
  <header class="flex items-center justify-between px-6 py-4 bg-white border-b-2 border-black">
    <!-- Logo -->
    <h1 class="text-2xl font-extrabold">MetaGoon</h1>

    <!-- Navigation -->
    <nav class="flex gap-6 font-semibold">
      <RouterLink to="/" class="hover:text-blue-600">Sākums</RouterLink>
      <RouterLink to="/vakances" class="hover:text-blue-600">Vakances</RouterLink>
      <RouterLink to="/favoriti" class="hover:text-blue-600">Favorīti</RouterLink>
    </nav>

    <!-- Auth buttons -->
    <div class="flex gap-3">
      <button class="px-4 py-2 bg-black text-white font-semibold rounded-md hover:bg-gray-800">
        Pieslēgties
      </button>
      <button class="px-4 py-2 bg-black text-white font-semibold rounded-md hover:bg-gray-800">
        <RouterLink to="/login"> Reģistrēties </RouterLink>
      </button>
    </div>
  </header>
</template>

<script setup>
import { RouterLink } from 'vue-router'
</script>