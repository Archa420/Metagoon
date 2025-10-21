<template>
  <div class="min-h-screen bg-[#0b0c10] text-gray-100 flex flex-col">
    <main class="flex-grow max-w-7xl mx-auto px-6 py-16 space-y-12">
      <!-- Page Title -->
      <section class="text-center space-y-2">
        <h1
          class="text-5xl font-extrabold bg-gradient-to-r from-indigo-400 via-fuchsia-400 to-cyan-400 bg-clip-text text-transparent"
        >
          Mani favorīti
        </h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">
          Šeit ir redzamas vakances, kuras esi saglabājis sev interesējošās.
        </p>
      </section>

      <!-- Favorites Grid -->
      <section
        v-if="favorites.length > 0"
        class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
      >
        <div
          v-for="fav in favorites"
          :key="fav.id"
          class="relative"
        >
          <JobCard
            :id="fav.vacancy.id"
            :logo="fav.vacancy.logo"
            :title="fav.vacancy.title"
            :company="fav.vacancy.company"
            :description="fav.vacancy.description"
            :salary="fav.vacancy.salary"
            :category="fav.vacancy.category"
            :county="fav.vacancy.county"
            :isFavorite="true"
            @remove="toggleFavorite(fav.vacancy.id)"
          />
        </div>
      </section>

      <!-- Empty State -->
      <section v-else class="text-center py-20 space-y-4">
        <h2
          class="text-3xl font-semibold text-gray-300 bg-gradient-to-r from-indigo-400 via-fuchsia-400 to-cyan-400 bg-clip-text text-transparent"
        >
          Nav nevienas saglabātas vakances
        </h2>
        <p class="text-gray-500 text-lg">
          Pārlūko
          <RouterLink
            to="/vakances"
            class="text-indigo-400 hover:text-indigo-300"
          >
            vakances
          </RouterLink>
          un pievieno tās favorītiem.
        </p>
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { RouterLink } from "vue-router";
import api from "@/services/api";
import JobCard from "@/components/JobCard.vue";

const token = localStorage.getItem("token");
const favorites = ref([]);

/**
 * Fetch all user's favorites
 */
const fetchFavorites = async () => {
  if (!token) return;
  try {
    const res = await api.get("/favorites", {
      headers: { Authorization: `Bearer ${token}` },
    });
    favorites.value = res.data;
  } catch (err) {
    console.error("Failed to load favorites:", err);
  }
};

/**
 * Toggle favorite (add/remove)
 */
const toggleFavorite = async (vacancyId) => {
  if (!token) return alert("Lūdzu pieslēdzies, lai pārvaldītu favorītus");
  try {
    const res = await api.post(`/favorites/toggle/${vacancyId}`, null, {
      headers: { Authorization: `Bearer ${token}` },
    });

    // If unfavorited, remove from list
    if (!res.data.favorited) {
      favorites.value = favorites.value.filter(
        (f) => f.vacancy.id !== vacancyId
      );
    }
  } catch (err) {
    console.error("Failed to toggle favorite:", err);
  }
};

onMounted(fetchFavorites);
</script>
