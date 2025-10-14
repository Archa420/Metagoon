<template>
  <div
    @click="goToVacancy"
    class="cursor-pointer group p-6 rounded-2xl border border-gray-700 bg-gray-900/60 shadow-md hover:border-indigo-500/40 hover:-translate-y-1 transition transform"
  >
    <div class="flex items-start gap-4">
      <img
        :src="logo ? `http://127.0.0.1:8000/storage/${logo}` : '/default-logo.png'"
        alt="company logo"
        class="w-16 h-16 rounded-xl object-cover border border-gray-700 group-hover:border-indigo-500 transition"
      />
      <div class="flex flex-col flex-1 space-y-1">
        <h2 class="text-xl font-semibold text-gray-100 group-hover:text-indigo-400 transition">{{ title }}</h2>
        <p class="text-sm text-gray-400">{{ company }}</p>
        <p class="mt-2 text-sm text-gray-300 line-clamp-2">{{ description }}</p>
        <p class="mt-3 font-medium text-indigo-400">Alga: {{ salary }}€</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";
const props = defineProps({
  id: Number,
  logo: String,
  title: String,
  company: String,
  salary: String,
  description: String,
});
const router = useRouter();
const goToVacancy = () => router.push(`/vacancy/${props.id}`);
</script>
