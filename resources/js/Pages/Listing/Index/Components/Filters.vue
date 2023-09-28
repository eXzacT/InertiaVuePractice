<template>
  <form @submit.prevent="filter">
    <div class="mb-8 mt-4 flex flex-wrap gap-2">
      <div class="flex flex-nowrap items-center">
        <input
          v-model.number="filterForm.priceFrom"
          type="text" placeholder="Price from" 
          class="input-filter-l w-32"
        />
        <input
          v-model.number="filterForm.priceTo"
          type="text" placeholder="Price to" 
          class="input-filter-r w-32"
        />
      </div>

      <div class="flex flex-nowrap items-center">
        <select
          v-model="filterForm.beds"
          class="input-filter-l w-28"
        >
          <option :value="null">Beds</option>
          <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
          <option>6+</option>
        </select>
        <select
          v-model="filterForm.baths"
          class="input-filter-r w-28"
        >
          <option :value="null">Baths</option>
          <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
          <option>6+</option>
        </select>
      </div>

      <div class="flex flex-nowrap items-center">
        <input
          v-model.number="filterForm.areaFrom"
          type="text" placeholder="Area from" 
          class="input-filter-l w-28"
        />
        <input
          v-model.number="filterForm.areaTo"
          type="text" placeholder="Area to" 
          class="input-filter-r w-28"
        />
      </div>

      <div class="flex flex-nowrap items-center">
        <select v-model="filterForm.by" class="input-filter input-filter-l w-24">
          <option value="created_at">Added</option>
          <option value="price">Price</option>
        </select>
        <select v-model="filterForm.order" class="input-filter input-filter-r w-26">
          <option v-for="option in sortOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
        </select>
      </div>

      <button type="submit" class="btn-normal">Filter</button>
      <button type="reset" @click="clear">Clear</button>
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { computed } from 'vue'

const props=defineProps({ 
  filters:Object, 
})

const sortLabels={
  created_at:[{
    label:'Latest',
    value:'desc',
  },
  {
    label:'Oldest',
    value:'asc', 
  }],
  price:[{
    label:'Pricey',
    value:'desc',
  },
  {
    label:'Cheapest',
    value:'asc', 
  }],
}

const sortOptions=computed(()=>sortLabels[filterForm.by])

const filterForm = useForm({
  priceFrom:props.filters.priceFrom ?? null,
  priceTo:props.filters.priceTo ?? null,
  beds:props.filters.beds ?? null,
  baths:props.filters.baths ?? null,
  areaFrom:props.filters.areaFrom ?? null,
  areaTo:props.filters.areaTo ?? null,
  by: props.filters.by ?? 'created_at',
  order: props.filters.order ?? 'desc',
})

const filter = () => {
  filterForm.get(
    route('listing.index'),
    {
      preserveState: true,
      preserveScroll: true,
    },
  )
}

const clear = () => {
  filterForm.priceFrom = null
  filterForm.priceTo = null
  filterForm.beds = null
  filterForm.baths = null
  filterForm.areaFrom = null
  filterForm.areaTo = null
  filterForm.order = null
  filterForm.by = null
  filter()
}

</script>