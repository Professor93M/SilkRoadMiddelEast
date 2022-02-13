<template>
    <div class="flex bg-gray-700">
        <button @click="increment" class="inc btn btn-outline-secondary text-gray-400 font-extrabold text-2xl rounded-tr-lg rounded-br-lg -ml-1 focus:ring-0">+</button>
        <input @keypress='onlyNumbers' type="text" name="number" disabled v-model="value" class="Input border-2 border-gray-400 z-10 text-center w-20 bg-gray-400 text-white text-2xl">
        <button @click="decrement" class="dec btn btn-outline-secondary text-gray-400 font-extrabold text-2xl rounded-tl-lg rounded-bl-lg -mr-1 focus:ring-0 z-0">-</button>
    </div>
</template>

<script>
export default {
    props:['max', 'min'],
    // props:{
    //     max: Number,
    //     min: Number,
    //     value: Number,
    // },
    data(){
        return{
            value: this.min
        }
    },
    methods:{
        onlyNumbers($event){
            let keyCode = ($event.keyCode ? $event.keyCode : $event.watch);
            if((keyCode < 48 || keyCode > 57) && keyCode !==46) {
                $event.preventDefault();
            }
        },
        increment(){
            if(this.value < this.max)
                this.value++
            else if(this.value > 1)
                this.value = 1
            this.$emit('inc', this.value)
        },
        decrement(){
            if(this.value > 1 && this.value <= this.max)
                this.value--
            else if(this.value <= this.max)
                this.value = this.max
            else
                this.value = this.max
            this.$emit('dec', this.value)
        },
        // decrement(){
        //     if(this.value > this.min && this.value <= this.max)
        //         this.value--
        //     else if(this.value <= this.max)
        //         this.value = this.max
        //     else
        //         this.value = this.max
        //     this.$emit('dec', this.value)
        // },
    },
}
</script>