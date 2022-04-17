<script>
    export default {
        computed: {
            computedMessage() {
                let msg = this.message;
                let arrMsg = [];

                if (typeof this.message == 'object') {
                    Object.keys(msg).forEach(function(value) {
                        Object.keys(msg[value]).forEach(function(key) {
                            arrMsg.push(msg[value][key]);
                        })
                    })
                } else {
                    arrMsg = this.message;
                }

                return arrMsg;
            },
            showIconMessage() {
                let strIcon = 'uil uil-exclamation-triangle';
                let strMessage = 'One or more errors found:';

                switch (this.modalVariant) {
                    case 'success':
                        strIcon = 'uil-check-circle';
                        strMessage = this.message;
                        break;
                }
                return {
                    icon: strIcon,
                    message: strMessage,
                }
            }
        },
        props: {
            message: {
                type: [String, Object],
                default: '',
            },
            modalVariant: {
                type: String,
                default: 'danger'
            },
            show: {
                default: false
            }
        }
    }
</script>

<template>
    <b-alert v-model="show" :variant="modalVariant" dismissible v-if="typeof computedMessage == 'string'">{{ computedMessage }}</b-alert>
    <b-alert v-model="show" :variant="modalVariant" dismissible v-else>
        <i v-bind:class="showIconMessage.icon"></i> <strong>{{ showIconMessage.message }}</strong>
        <ul class="mb-0">
            <li v-for="value in computedMessage">
                {{ value }}
            </li>
        </ul>
    </b-alert>
</template>