<script setup>
defineProps({
  logo: String,
  title: String,
  company: String,
  salary: String,
  description: String,
})
</script>

<template>
  <div class="flex items-start gap-4 p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition">
    <img :src="logo" alt="company logo" class="w-16 h-16 rounded-xl object-cover border" />
    <div class="flex flex-col">
      <h2 class="text-xl font-semibold text-gray-800">{{ title }}</h2>
      <p class="text-sm text-gray-500">{{ company }}</p>
      <p class="mt-2 text-sm text-gray-700">{{ description }}</p>
      <p class="mt-3 font-medium text-indigo-600">Likme: {{ salary }}</p>
    </div>
  </div>
</template>
