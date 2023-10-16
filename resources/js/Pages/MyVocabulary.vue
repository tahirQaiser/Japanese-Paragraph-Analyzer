<template>
    <div class="app-container mt-5">
        <div class="d-flex justify-content-between">
            <h3>My Vocabulary</h3>
            <Link class="text-decoration-none" href="/">Home</Link>
        </div>
        <form v-if="vocabularies.length" @submit.prevent="submitAnswer">
            <div class="mt-5 mb-3">
                <h5>What is meaning of <h4 class="d-inline">{{ question.word }}</h4></h5>
                <div v-if="error" class="form-text text-danger">{{ error }}</div>
                <div v-if="success" class="form-text text-success">{{ success }}</div>
            </div>

            <div class="form-group my-3">
                <div class="form-check mb-4" v-for="vocabulary in vocabularies">
                    <input class="form-check-input" :id="`radio-${vocabulary.id}`" type="radio" v-model="answer"
                           :value="vocabulary.id">
                    <label class="form-check-label" :for="`radio-${vocabulary.id}`">{{
                            vocabulary.meaning.join(', ')
                        }}</label>
                </div>
            </div>


            <button type="submit" class="btn btn-sm btn-dark" :disabled="processing">Submit</button>
            <!-- Show loading on while processing -->
            <svg v-if="processing" style="width: 50px; height: 50px;" xmlns="http://www.w3.org/2000/svg"
                 x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                <path fill="#333"
                      d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                  <animateTransform
                      attributeName="transform"
                      attributeType="XML"
                      type="rotate"
                      dur="1s"
                      from="0 50 50"
                      to="360 50 50"
                      repeatCount="indefinite"/>
              </path>
            </svg>
        </form>

        <p v-else>No vocabulary found in database</p>
    </div>
</template>

<script setup>
import {ref} from "vue";

const props = defineProps({
    vocabularies: {
        type: Array,
        default: []
    }
})
const error = ref('');
const success = ref('');
const answer = ref(null);
const processing = ref(false);
const question = ref(props.vocabularies[Math.floor(Math.random() * 4)]);

const submitAnswer = (index) => {
    error.value = success.value = '';
    if (question.value.id === answer.value) {
        success.value = 'Your answer is correct';
    } else {
        error.value = `Your answer is incorrect, correct answer is: ${question.value.meaning.join(', ')}`;
    }
}

</script>

<style scoped>
.app-container {
    margin: auto;
    max-width: 700px;
}
</style>