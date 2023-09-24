import { computed, isRef} from "vue"

export const useMonthlyPayment = (total,interestRate,duration) => {
    
    //Utility function to return value if it's a computed variable, if not just return the value itself
    const getValue = (x) => isRef(x) ? x.value : x

    const monthlyPayment = computed(() => {
        const principle = getValue(total)
        const monthlyInterest = getValue(interestRate) / 100 / 12
        const numberOfPaymentMonths = getValue(duration) * 12
        return principle * monthlyInterest * (Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) / (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
    })

    const totalPaid=computed(()=>{
        return getValue(duration)*12*monthlyPayment.value
    })
    const totalInterest=computed(()=>totalPaid.value-getValue(total))

    return {monthlyPayment, totalPaid, totalInterest}
}