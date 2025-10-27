<template>
  <div class="min-h-screen w-full bg-[#0b0c10] text-gray-100">
    <div class="home mx-auto max-w-7xl px-6 py-16 space-y-24 text-gray-100">
      <!-- HERO -->
      <section
        class="relative overflow-hidden rounded-3xl border border-indigo-900/30 bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 shadow-2xl"
      >
        <div
          class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-indigo-800/20 via-fuchsia-800/10 to-transparent pointer-events-none"
        ></div>

        <div class="grid gap-10 p-10 lg:grid-cols-2 lg:p-16 relative z-10">
          <!-- LEFT COLUMN -->
          <div class="space-y-6">
            <h1
              class="text-5xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-400 via-fuchsia-400 to-cyan-400 bg-clip-text text-transparent"
            >
              Atrodi savu nākamo darbu ar MetaGoon
            </h1>
            <p class="text-lg leading-relaxed text-gray-400">
              Inteliģenti filtri, personalizēti paziņojumi un moderns dizains, kas padara darba meklēšanu vienkāršu un patīkamu.
            </p>

            <!-- Search bar -->
            <form
              class="flex flex-col gap-3 rounded-2xl border border-gray-700 bg-gray-900/70 p-4 shadow-lg md:flex-row"
              @submit.prevent="handleSearch"
            >
              <input
                v-model="keyword"
                type="text"
                placeholder="🔍 Amats vai atslēgvārds"
                class="flex-1 rounded-xl border border-gray-700 bg-gray-800/60 px-4 py-2 text-sm text-gray-100 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40"
              />

              <select
                v-model="county"
                class="w-full md:w-56 rounded-xl border border-gray-700 bg-gray-800/60 px-4 py-2 text-sm text-gray-100 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40"
              >
                <option value="">📍 Izvēlies pilsētu</option>
                <option value="Rīga">Rīga</option>
                <option value="Liepāja">Liepāja</option>
                <option value="Jelgava">Jelgava</option>
                <option value="Daugavpils">Daugavpils</option>
                <option value="Valmiera">Valmiera</option>
                <option value="Ogre">Ogre</option>
                <option value="Ventspils">Ventspils</option>
                <option value="Rēzekne">Rēzekne</option>
              </select>

              <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 px-5 py-2 text-sm font-semibold text-white shadow hover:opacity-90 active:scale-[.98] transition"
              >
                Meklēt
              </button>
            </form>

            <!-- CTAs -->
            <div class="flex flex-wrap gap-3 pt-2">
              <RouterLink
                to="/registracija"
                class="rounded-xl bg-indigo-600/90 hover:bg-indigo-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg focus:ring-2 focus:ring-indigo-500/60 transition"
              >
                Reģistrēties bez maksas
              </RouterLink>
              <RouterLink
                to="/vakances"
                class="rounded-xl border border-gray-700 px-5 py-2.5 text-sm font-semibold text-gray-200 hover:bg-gray-800/80 transition"
              >
                Pārlūkot vakances
              </RouterLink>
            </div>
          </div>

          <!-- RIGHT COLUMN: Stats -->
          <div class="flex items-center justify-center">
            <div
              class="w-full rounded-2xl border border-indigo-900/30 bg-gray-900/60 p-8 shadow-lg backdrop-blur-lg space-y-8"
            >
              <h3 class="text-gray-400 text-sm font-medium">MetaGoon skaitļos</h3>
              <div class="grid grid-cols-3 gap-6">
                <StatCard :number="stats.vacancies" label="Vakances" />
                <StatCard :number="stats.companies" label="Darba devēji" />
                <StatCard :number="stats.unemployed" label="Kandidāti" />
              </div>
              <p class="text-gray-400 text-sm border-t border-gray-700 pt-4">
                Saglabā favorītus un saņem paziņojumus par jaunām vakancēm, kas atbilst taviem kritērijiem.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- FEATURES -->
      <section class="space-y-10">
        <h2
          class="text-center text-3xl font-extrabold bg-gradient-to-r from-indigo-400 via-fuchsia-400 to-cyan-400 bg-clip-text text-transparent"
        >
          Kā MetaGoon palīdz
        </h2>
        <div class="grid gap-8 md:grid-cols-3">
          <FeatureCard
            title="Gudra filtrēšana"
            desc="Atlasiet pēc pilsētas, atslēgvārdiem un kategorijām, lai ātrāk atrastu piemērotas vakances."
            iconColor="from-indigo-500 to-cyan-400"
          />
          <FeatureCard
            title="Favorīti un paziņojumi"
            desc="Saglabājiet iecienītās vakances un saņemiet brīdinājumus par jauniem piedāvājumiem."
            iconColor="from-fuchsia-500 to-indigo-400"
          />
          <FeatureCard
            title="Pārskatāma pieredze"
            desc="Vienkārša saskarne un ātra navigācija, lai nenokavētu labākās iespējas."
            iconColor="from-cyan-500 to-fuchsia-400"
          />
        </div>
      </section>

      <!-- POPULAR CATEGORIES -->
      <section class="space-y-8">
        <div class="flex items-center justify-between">
          <h2 class="text-2xl font-extrabold">Populārās kategorijas</h2>
          <RouterLink
            to="/vakances"
            class="text-sm font-semibold text-indigo-400 hover:text-indigo-300 transition"
          >
            Skatīt visas →
          </RouterLink>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
          <CategoryPill label="IT & Programmēšana" query="IT & Programmēšana" />
          <CategoryPill label="Pārdošana" query="Pārdošana" />
          <CategoryPill label="Mārketings" query="Mārketings" />
          <CategoryPill label="Finanses" query="Finanses" />
          <CategoryPill label="Loģistika" query="Loģistika" />
          <CategoryPill label="Ražošana" query="Ražošana" />
          <CategoryPill label="Klientu atbalsts" query="Klientu atbalsts" />
          <CategoryPill label="Veselība" query="Veselība" />
        </div>
      </section>

      <!-- CTA -->
      <section
        class="rounded-3xl border border-indigo-900/30 bg-gradient-to-r from-indigo-950 via-gray-900 to-gray-950 p-10 text-center shadow-xl"
      >
        <h3
          class="text-3xl font-extrabold bg-gradient-to-r from-indigo-400 via-fuchsia-400 to-cyan-400 bg-clip-text text-transparent"
        >
          Gatavs sākt?
        </h3>
        <p class="mt-2 text-gray-400">
          Izveido kontu minūtes laikā un atrodi savu nākamo iespēju.
        </p>
        <div class="mt-6 flex justify-center gap-3">
          <RouterLink
            to="/registracija"
            class="rounded-xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 px-6 py-2.5 text-sm font-semibold text-white shadow-lg hover:opacity-90 transition"
          >
            Reģistrēties
          </RouterLink>
          <RouterLink
            to="/login"
            class="rounded-xl border border-gray-700 px-6 py-2.5 text-sm font-semibold text-gray-200 hover:bg-gray-800 transition"
          >
            Pieslēgties
          </RouterLink>
        </div>
      </section>
    </div>
    <!-- AI Assistant Floating Button -->
    <div class="fixed bottom-6 right-6 z-50">
      <!-- Chat Window -->
      <transition name="fade">
        <div
          v-if="chatOpen"
          class="mb-4 w-80 h-96 rounded-2xl border border-gray-700 bg-gray-900/90 backdrop-blur-md shadow-2xl flex flex-col overflow-hidden"
        >
          <div class="bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 p-3 text-white font-semibold">
            MetaGoon Assistant
          </div>
          <div class="flex-1 p-3 text-sm text-gray-300 overflow-y-auto space-y-2">
            <div
              v-for="(msg, index) in chatMessages"
              :key="index"
              :class="msg.sender === 'user' ? 'text-right' : 'text-left'"
            >
              <div
                :class="[
                  'inline-block px-3 py-2 rounded-xl max-w-[80%]',
                  msg.sender === 'user'
                    ? 'bg-gradient-to-r from-indigo-600 to-fuchsia-500 text-white ml-auto'
                    : 'bg-gray-800 text-gray-200'
                ]"
              >
                {{ msg.text }}
              </div>
            </div>

            <div v-if="loading" class="text-gray-500 text-center text-sm pt-2">
              Rakstu atbildi...
            </div>
          </div>

          <div class="border-t border-gray-700 p-3 flex gap-2">
            <input
              v-model="userMessage"
              @keyup.enter="sendMessage"
              type="text"
              placeholder="Raksti ziņu..."
              class="flex-1 rounded-xl border border-gray-700 bg-gray-800/60 px-3 py-2 text-sm text-gray-100 outline-none"
            />
            <button
              @click="sendMessage"
              class="rounded-xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 px-4 py-2 text-sm font-semibold text-white shadow hover:opacity-90 transition"
            >
              Sūtīt
            </button>
          </div>
        </div>
      </transition>

      <!-- Floating Button -->
      <button
        @click="toggleChat"
        class="rounded-full bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 p-4 shadow-lg hover:opacity-90 active:scale-95 transition"
      >
        💬
      </button>
    </div>
  </div>
</template>

<script setup>
import { RouterLink, useRouter } from "vue-router";
import { ref, defineComponent, h, onMounted } from "vue";
import api from "@/services/api.js"; // make sure this is your axios instance

/* --- Search Logic --- */
const router = useRouter();
const keyword = ref("");
const county = ref("");
const chatOpen = ref(false);

const handleSearch = () => {
  if (!keyword.value && !county.value) return;
  router.push({
    path: "/vakances",
    query: { keyword: keyword.value, county: county.value },
  });
};

const toggleChat = () => {
  chatOpen.value = !chatOpen.value;
};
/* --- AI Chat Logic --- */
const chatMessages = ref([
  { sender: "ai", text: "👋 Sveiks! Es esmu MetaGoon palīgs. Kā varu palīdzēt?" },
]);
const userMessage = ref("");
const loading = ref(false);

const sendMessage = async () => {
  if (!userMessage.value.trim()) return;

  // Add user message immediately
  chatMessages.value.push({ sender: "user", text: userMessage.value });
  const messageToSend = userMessage.value;
  userMessage.value = "";
  loading.value = true;

  try {
    const res = await fetch("http://localhost:8000/api/assistant", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ message: messageToSend }),
    });

    const data = await res.json();
    chatMessages.value.push({ sender: "ai", text: data.reply || "Nav atbildes." });
  } catch (err) {
    chatMessages.value.push({ sender: "ai", text: "⚠️ Neizdevās sazināties ar AI palīgu." });
    console.error(err);
  } finally {
    loading.value = false;
  }
};


/* --- Dynamic Stats --- */
const stats = ref({
  vacancies: 0,
  companies: 0,
  unemployed: 0,
});

const fetchStats = async () => {
  try {
    const res = await api.get("/stats");
    stats.value = res.data;
  } catch (err) {
    console.error("Failed to load stats:", err);
  }
};

onMounted(fetchStats);

/* --- Stat Card --- */
const StatCard = defineComponent({
  props: { number: [String, Number], label: String },
  setup(props) {
    return () =>
      h("div", { class: "text-center rounded-xl bg-gray-800/50 p-4 border border-gray-700" }, [
        h("div", { class: "text-2xl font-bold text-white" }, props.number),
        h("div", { class: "text-xs text-gray-400" }, props.label),
      ]);
  },
});

/* --- Feature Card --- */
const FeatureCard = defineComponent({
  props: { title: String, desc: String, iconColor: String },
  setup(props) {
    return () =>
      h(
        "div",
        {
          class:
            "rounded-2xl border border-gray-700 bg-gray-900/60 p-6 shadow-lg hover:border-indigo-500/40 transition",
        },
        [
          h(
            "div",
            {
              class: `mb-4 h-10 w-10 rounded-xl bg-gradient-to-r ${props.iconColor} flex items-center justify-center text-white`,
            },
            "★"
          ),
          h("h3", { class: "text-lg font-semibold text-white" }, props.title),
          h("p", { class: "mt-2 text-sm text-gray-400" }, props.desc),
        ]
      );
  },
});

/* --- Category Pill --- */
const CategoryPill = defineComponent({
  props: { label: String, query: String },
  setup(props) {
    return () =>
      h(
        RouterLink,
        {
          to: { path: "/vakances", query: { category: props.query } },
          class:
            "inline-flex items-center justify-center rounded-2xl border border-gray-700 bg-gray-900/60 px-4 py-3 text-sm font-medium text-gray-200 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-500/60 hover:text-indigo-400",
        },
        [
          h("span", {
            class:
              "mr-2 inline-flex h-2.5 w-2.5 rounded-full bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-cyan-500",
          }),
          props.label,
        ]
      );
  },
});
</script>


<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
.home {
  background-color: #0b0c10;
}
:global(body) {
  background-color: #0b0c10;
  color: #f3f4f6;
}
</style>