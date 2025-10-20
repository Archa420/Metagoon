<template>
  <div class="max-w-4xl mx-auto p-6 space-y-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">My Favorites</h1>

    <div v-if="favorites.length > 0" class="space-y-4">
      <div v-for="fav in favorites" :key="fav.id" class="flex items-start gap-4 p-6 bg-white rounded-2xl shadow-md">
        <img
          :src="fav.vacancy.logo ? 'http://127.0.0.1:8000/storage/' + fav.vacancy.logo : ''"
          alt="Logo"
          class="w-32 h-32 rounded-xl object-cover border"
        />
        <div class="flex flex-col">
          <h2 class="text-xl font-semibold text-gray-800">{{ fav.vacancy.title }}</h2>
          <p class="text-sm text-gray-500">{{ fav.vacancy.company }}</p>
          <p class="mt-2 text-sm text-gray-700">{{ fav.vacancy.description }}</p>
          <p class="mt-3 font-medium text-indigo-600">Salary: {{ fav.vacancy.salary }}</p>
        </div>
      </div>
    </div>
    <div v-else class="text-gray-500">No favorites yet.</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "@/services/api";

const token = localStorage.getItem("token");
const favorites = ref([]);

const fetchFavorites = async () => {
  if (!token) return;
  try {
    const res = await api.get("/favorites", {
      headers: { Authorization: `Bearer ${token}` },
    });
    favorites.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

onMounted(fetchFavorites);
</script>
