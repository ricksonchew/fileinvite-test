<script>
    import * as API_URL from '@constants/api'
    import moment from 'moment'

    export default {
        methods: {
            fetchList(args) {
                this.$store.dispatch('dataTable/fetchList', {
                    apiUrl: API_URL.API_URL.bookings.default,
                    params: args,
                });
            },
            triggerShowEditModal(value) {
                this.bookingId = value;
                this.showEditModal = true;
            },
        },
        beforeMount() {
            this.fetchList()
        },
        beforeCreate() {
            this.$store.commit('dataTable/DATA_TABLE_FIELDS', [
                { key: 'meeting_room', label: 'Meeting Room', sortable: true },
                { key: 'booked_by', label: 'Booked By', sortable: true },
                { key: 'booking_date_from', label: 'Date Booked', sortable: true },
                { key: 'booking_date_to', label: 'Time', sortable: true },
                { key: 'actions', sortable: false },
            ]);
        },
        data() {
            return {
                dataTable: this.$store.getters['dataTable/dataTableGetter'],
                showEditModal: false,
                bookingId: null,
                moment: moment,
            }
        }
    }
</script>

<template>
    <div>
        <b-table
            :items="dataTable.items"
            :fields="dataTable.fields"
            :per-page="dataTable.perPage"
            :busy="dataTable.isBusy"
            responsive
            hover
            show-empty
        >
            <template v-slot:table-busy>
                <div class="text-center my-2">
                    <b-spinner class="align-middle mr-1"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
            <template v-slot:cell(actions)="data">
                <b-button variant="link" class="p-0" @click="triggerShowEditModal(data.item.booking_id)"><i class="uil uil-edit"></i></b-button>
                <b-button variant="link" class="p-0"><i class="uil uil-trash-alt"></i></b-button>
            </template>
            <template v-slot:cell(user)="data">
                {{ data.item.user.email }}
            </template>
            <template v-slot:cell(booking_date_from)="data">
                {{ moment(data.item.booking_date_from).format('MMMM DD YYYY') }}
            </template>
            <template v-slot:cell(booking_date_to)="data">
                {{ moment(data.item.booking_date_from).format('h:mm A') }} - {{ moment(data.item.booking_date_to).format('h:mm A') }}
            </template>
        </b-table>
        <b-modal v-model="showEditModal" :title="'Edit Booking'" size="lg" hide-footer body-class="p-0">
            <FormBookingEdit :bookingId="bookingId" />
        </b-modal>
    </div>
</template>