<template>
  <h1 class="text-3xl mb-4">Your listings</h1>

  <section>
    <RealtorFilters :filters="filters" />
  </section>

  <section v-if="listings.data.length" class="grid grid-cols-1 lg:grid-cols-2 gap-2">
    <Box v-for="(listing) in listings.data" :key="listing.id" :class="{'border-dashed':listing.deleted_at}">
      <div class="flex flex-col md:flex-row gap-2 md:items-center justify-between">
        <div :class="{'opacity-25' : listing.deleted_at}">
          <div v-if="listing.sold_at" class="sold-tag w-12">Sold</div>
          <div class="xl:flex items-center gap-2">
            <Price :price="listing.price" class="text-2xl font-medium" />
            <ListingSpace :listing="listing" />
          </div>
          <ListingAddress :listing="listing" class="text-gray-500" />
        </div>
        <section>
          <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
            <a
              class="btn-outline text-xs font-medium"
              :href="route('listing.show',{listing:listing.id})"
              target="_blank"
            >Preview</a>
            <Link class="btn-outline text-xs font-medium" :href="route('realtor.listing.edit',{listing:listing.id})">Edit</Link>
            <Link
              v-if="!listing.deleted_at"
              class="btn-outline text-xs font-medium"
              :href="route('realtor.listing.destroy',{listing:listing.id})"
              method="delete"
              as="button"
            >
              Delete
            </Link>
            <Link
              v-else
              class="btn-outline text-xs font-medium"
              :href="route('realtor.listing.restore',{listing:listing.id})"
              method="put"
              as="button"
            >
              Restore
            </Link>
          </div>
          <div class="mt-2">
            <Link
              :href="route('realtor.listing.image.create', {listing: listing.id})"
              class="block w-full btn-outline text-xs font-medium text-center"
            >
              Number of Images: {{ listing.images_count }}
            </Link>
          </div>
          <div class="mt-2">
            <Link
              :href="route('realtor.listing.show', {listing: listing.id})"
              class="block w-full btn-outline text-xs font-medium text-center"
            >
              Number of Offers: {{ listing.offers_count }}
            </Link>
          </div>
        </section>
      </div>
    </Box>
  </section>

  <EmptyState v-else>No listings yet</EmptyState>

  <section v-if="listings.data.length" class="w-full flex justify-center mt-4 mb-4">
    <Pagination :links="listings.links" />
  </section>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue'
import Price from '@/Components/Price.vue'
import ListingAddress from '@/Components/ListingAddress.vue'
import { Link } from '@inertiajs/inertia-vue3'
import RealtorFilters from '@/Pages/Realtor/Index/Components/RealtorFilters.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import EmptyState from '@/Components/UI/EmptyState.vue'
import ListingSpace from "@/Components/ListingSpace.vue";
import route from "ziggy-js/src/js";

// Define the props
const { listings, filters } = defineProps({
  listings: Object,
  filters: Object,
})
</script>
