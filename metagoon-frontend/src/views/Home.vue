<template>
  <div class="home mx-auto max-w-7xl px-6 py-10 space-y-16">
    <!-- HERO -->
    <section
      class="relative overflow-hidden rounded-3xl border border-black/10 bg-white/80 backdrop-blur shadow-xl dark:bg-gray-900/80 dark:border-white/10"
    >
      <!-- Gradient accent top -->
      <div class="h-1 w-full bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-400"></div>

      <div class="grid gap-10 p-10 lg:grid-cols-2 lg:p-14">
        <div class="space-y-6">
          <h1
            class="text-4xl font-extrabold tracking-tight sm:text-5xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 bg-clip-text text-transparent"
          >
            Atrodi savu nākamo darbu ar MetaGoon
          </h1>
          <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
            Gudri filtri, favorīti un paziņojumi — viss, lai darba meklēšana būtu
            ātra, pārskatāma un ērta.
          </p>

          <!-- Search bar (hero) -->
          <form
            class="flex flex-col gap-3 rounded-2xl border border-gray-200/70 bg-white/70 p-3 shadow dark:border-gray-700 dark:bg-gray-800/70 md:flex-row"
            @submit.prevent
          >
            <input
              type="text"
              placeholder="Atslēgvārdi (piem., ‘programmētājs’)"
              class="flex-1 rounded-xl border border-gray-300 px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40 dark:border-gray-600 dark:bg-gray-900/60"
              aria-label="Atslēgvārdi"
            />
            <input
              type="text"
              placeholder="Pilsēta (piem., Rīga)"
              class="w-full md:w-56 rounded-xl border border-gray-300 px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40 dark:border-gray-600 dark:bg-gray-900/60"
              aria-label="Pilsēta"
            />
            <RouterLink
              to="/vakances"
              class="inline-flex items-center justify-center rounded-xl bg-black px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-800 active:scale-[.99] dark:bg-white dark:text-black dark:hover:bg-gray-100"
              aria-label="Meklēt vakances"
            >
              Meklēt
            </RouterLink>
          </form>

          <!-- Primary CTAs -->
          <div class="flex flex-wrap gap-3">
            <RouterLink
              to="/registracija"
              class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/60"
            >
              Reģistrēties bez maksas
            </RouterLink>
            <RouterLink
              to="/vakances"
              class="rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800"
            >
              Pārlūkot vakances
            </RouterLink>
          </div>
        </div>

        <!-- Hero visual / stats card -->
        <div class="flex items-stretch">
          <div
            class="flex w-full flex-col justify-between rounded-2xl border border-black/10 bg-white/70 p-6 shadow-lg dark:border-white/10 dark:bg-gray-900/60"
          >
            <div class="space-y-5">
              <div class="text-sm font-medium text-gray-500 dark:text-gray-400">MetaGoon skaitļos</div>
              <div class="grid grid-cols-3 gap-4">
                <div class="rounded-xl bg-gray-50 p-4 text-center dark:bg-gray-800/70">
                  <div class="text-2xl font-extrabold">2,450+</div>
                  <div class="text-xs text-gray-500">Vakances</div>
                </div>
                <div class="rounded-xl bg-gray-50 p-4 text-center dark:bg-gray-800/70">
                  <div class="text-2xl font-extrabold">780+</div>
                  <div class="text-xs text-gray-500">Darba devēji</div>
                </div>
                <div class="rounded-xl bg-gray-50 p-4 text-center dark:bg-gray-800/70">
                  <div class="text-2xl font-extrabold">12k+</div>
                  <div class="text-xs text-gray-500">Kandidāti</div>
                </div>
              </div>
            </div>

            <div class="mt-6 rounded-xl border border-dashed border-gray-300 p-4 text-sm text-gray-600 dark:border-gray-700 dark:text-gray-300">
              <p>
                Saglabā favorītus un saņem paziņojumus par jaunām vakancēm, kas atbilst
                taviem kritērijiem.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FEATURES -->
    <section class="space-y-8">
      <h2 class="text-center text-2xl font-extrabold tracking-tight">
        Kā MetaGoon palīdz
      </h2>
      <div class="grid gap-6 md:grid-cols-3">
        <!-- Feature 1 -->
        <div
          class="rounded-2xl border border-black/10 bg-white/80 p-6 shadow dark:border-white/10 dark:bg-gray-900/80"
        >
          <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600/10">
            <!-- icon -->
            <svg viewBox="0 0 24 24" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="currentColor">
              <path d="M10 18a8 8 0 1 1 5.293-14.293l4.5 4.5-1.414 1.414-4.5-4.5A6 6 0 1 0 16 10h-2l3 3 3-3h-2a8 8 0 0 1-8 8z"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold">Gudra filtrēšana</h3>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            Atlasiet pēc pilsētas, atslēgvārdiem un kategorijām, lai ātrāk atrastu piemērotas vakances.
          </p>
        </div>

        <!-- Feature 2 -->
        <div
          class="rounded-2xl border border-black/10 bg-white/80 p-6 shadow dark:border-white/10 dark:bg-gray-900/80"
        >
          <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-fuchsia-600/10">
            <svg viewBox="0 0 24 24" class="h-5 w-5 text-fuchsia-600 dark:text-fuchsia-400" fill="currentColor">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5A5.5 5.5 0 0 1 7.5 3c1.74 0 3.41.81 4.5 2.09A6.002 6.002 0 0 1 22 9c0 3.87-3.4 6.95-8.55 11.54L12 21.35z"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold">Favorīti un paziņojumi</h3>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            Saglabājiet iecienītās vakances un saņemiet brīdinājumus par jauniem piedāvājumiem.
          </p>
        </div>

        <!-- Feature 3 -->
        <div
          class="rounded-2xl border border-black/10 bg-white/80 p-6 shadow dark:border-white/10 dark:bg-gray-900/80"
        >
          <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-600/10">
            <svg viewBox="0 0 24 24" class="h-5 w-5 text-cyan-600 dark:text-cyan-400" fill="currentColor">
              <path d="M3 5a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v2H3V5zm0 6h20v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8z"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold">Pārskatāma pieredze</h3>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            Vienkārša saskarne un ātra navigācija, lai nenokavētu labākās iespējas.
          </p>
        </div>
      </div>
    </section>

    <!-- KATEGORIJAS -->
    <section class="space-y-6">
      <div class="flex items-center justify-between">
        <h2 class="text-2xl font-extrabold tracking-tight">Populārās kategorijas</h2>
        <RouterLink
          to="/vakances"
          class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400"
        >
          Skatīt visas →
        </RouterLink>
      </div>

      <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <CategoryPill label="IT & Programmēšana" query="it" />
        <CategoryPill label="Pārdošana" query="pardosana" />
        <CategoryPill label="Mārketings" query="marketings" />
        <CategoryPill label="Finanses" query="finanses" />
        <CategoryPill label="Loģistika" query="logistika" />
        <CategoryPill label="Ražošana" query="razosana" />
        <CategoryPill label="Klientu atbalsts" query="support" />
        <CategoryPill label="Veselība" query="veseliba" />
      </div>
    </section>

    <!-- CTA -->
    <section
      class="rounded-3xl border border-black/10 bg-white/80 p-8 text-center shadow-xl dark:border-white/10 dark:bg-gray-900/80"
    >
      <h3 class="text-2xl font-extrabold">
        Gatavs sākt? Izveido kontu minūtes laikā.
      </h3>
      <p class="mt-2 text-gray-600 dark:text-gray-300">
        Saglabā favorītus, seko jaunumiem un kandidē ātrāk.
      </p>
      <div class="mt-5 flex justify-center gap-3">
        <RouterLink
          to="/registracija"
          class="rounded-xl bg-black px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-100"
        >
          Reģistrēties
        </RouterLink>
        <RouterLink
          to="/login"
          class="rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800"
        >
          Pieslēgties
        </RouterLink>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { defineComponent, h } from 'vue'

type CategoryPillProps = {
  label: string
  query: string
}

/** Kategorijas “pill” saite uz vakancēm ar query parametru */
const CategoryPill = defineComponent({
  name: 'CategoryPill',
  props: {
    label: { type: String, required: true },
    query: { type: String, required: true }
  },
  setup(props: CategoryPillProps) {
    return () =>
      h(
        RouterLink,
        {
          to: { path: '/vakances', query: { category: props.query } },
          class:
            'inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white/70 px-4 py-3 text-sm font-medium shadow-sm transition hover:-translate-y-0.5 hover:shadow md:justify-start dark:border-gray-700 dark:bg-gray-800/70'
        },
        {
          default: () => [
            // small dot icon
            h(
              'span',
              {
                class:
                  'mr-2 inline-flex h-2.5 w-2.5 rounded-full bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500'
              },
              []
            ),
            props.label
          ]
        }
      )
  }
})
</script>
