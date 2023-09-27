<template>
  <Box>
    <template #header>#Offer {{ offer.id }} <span v-if="offer.accepted_at" class="sold-tag">accepted</span></template>
    
    <section class="flex items-center justify-between">
      <div>
        <Price :price="offer.amount" class="text-xl" />
        
        <div class="text-gray-500">
          Difference <Price :price="difference" />
        </div>
        
        <div class="text-gray-500 text-sm">
          Offer made by {{ offer.bidder.name }}
        </div>
        
        <div class="text-gray-500 text-sm">
          Offer made on {{ offerCreatedAt }}
        </div>
      </div>
      <div>
        <Link
          v-if="!isSold"
          :href="route('realtor.offer.accept',offer.id)"
          class="btn-outline text-xs font-medium" 
          as="button"
          method="put"
        >
          Accept
        </Link>
      </div>
    </section>
  </Box>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue'
import Price from '@/Components/Price.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { computed } from 'vue'

const { offer,listingPrice,isSold }=defineProps({
  offer: Object,
  listingPrice: Number,
  isSold: Boolean,
})

const difference = computed(
  () => offer.amount - listingPrice)

const offerCreatedAt = computed(
  () => new Date(offer.created_at).toDateString())

</script>