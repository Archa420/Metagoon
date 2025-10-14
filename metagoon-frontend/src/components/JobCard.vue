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

const goToVacancy = () => {
  router.push(`/vacancy/${props.id}`);
};
</script>

<template>
  <div
    @click="goToVacancy"
    class="cursor-pointer flex items-start gap-4 p-6 bg-gray-900/60 rounded-2xl border border-gray-700 shadow-md hover:shadow-lg transition"
  >
    <img
      :src="logo ? `http://127.0.0.1:8000/storage/${logo}` : '/default-logo.png'"
      alt="company logo"
      class="w-16 h-16 rounded-xl object-cover border border-gray-700"
    />
    <div class="flex flex-col flex-1">
      <h2 class="text-xl font-semibold text-gray-100">{{ title }}</h2>
      <p class="text-sm text-gray-400">{{ company }}</p>
      <p class="mt-2 text-sm text-gray-300">{{ description }}</p>
      <p class="mt-3 font-medium text-indigo-400">Likme: {{ salary }}</p>
    </div>
  </div>
</template>
