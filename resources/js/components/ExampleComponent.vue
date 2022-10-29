<template>
<div class="col-md-8">
    <div class="message-input mt-3">
        <div class="form">
            <input name="message" v-model="message" class="form-control" placeholder="ここに文章を入力してください">
            <button type="button" @click="send()" class="btn btn-primary mt-2"><i class="fas fa-paper-plane"></i></button>
        </div>
        <div><input type="checkbox" v-model="checked"> 位置情報を登録(チェックを外すと位置情報は送信されません)</div>
        <div class="menu">
            <h5>簡易メニュー(選択して送信すれば送れます)</h5>
            <li @click="message = '無事です、安心してください'">無事です、安心してください</li>
            <li @click="message = '助けてください'">助けてください</li>
            <li @click="message = 'けがをしています'">けがをしています</li>
        </div>
    </div>
    <div class="message-area">
        <div v-for="message in messages" :key="message.id" class="message-wrap">
            <!-- 自分のメッセージ -->
            <div v-if="message.user_id === authUser" class="self">
                <div v-for="user in users" :key="user.id">
                    <div class="user-name" v-if="message.user_id === user.id">{{ user.name }}</div>
                </div>
                <div class="self-message-content">{{ message.content }}<br>
                    <span v-if="message.latitude != null">{{ message.latitude }},{{ message.longitude }}</span>
                </div>
                <small>{{ message.created_at }}</small>
            </div>
            
            <div v-else>
                <div v-for="user in users" :key="user.id">
                    <div class="user-name" v-if="message.user_id === user.id">{{ user.name }}</div>
                </div>
                <div class="message-content">{{ message.content }}<br>
                    <span v-if="message.latitude != null">{{ message.latitude }},{{ message.longitude }}</span>
                    <span v-else>位置情報がありません</span>
                </div>
                <small>{{ message.created_at }}</small>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data(){
            return {
                message: '',
                messages: [],
                users: [],
                authUser:[],
                lat: 0,
                lng: 0,
                checked:true,
            };
        },
        methods: {
            send(){
                const url = 'message/ajax/store';
                let param={};
                if(this.checked === true){
                    param = {
                        content:this.message,
                        user_id:this.authUser,
                        latitude:this.lat,
                        longitude:this.lng
                    };
                }else{
                    param = {
                        content:this.message,
                        user_id:this.authUser,
                        latitude:null,
                        longitude:null
                    };
                }
                axios.post(url,param).then((response) => {
                    this.message = '';
                });
            },
            getMessage() {
                axios.get('message/ajax/index').then((response) => {
                    this.messages = response.data;
                });
            },
            getUsers(){
                axios.get('message/ajax/users').then((response) => {
                    this.users = response.data;
                });
            },
            getAuthUser(){
                axios.get('message/ajax/authUser').then((response) => {
                    this.authUser = response.data;
                });
            },
        },
        mounted (){
            this.getMessage();
            this.getUsers();
            this.getAuthUser();

            Echo.channel('chat').listen('CreatedMessage', (e) => {
                this.getMessage();
            });

            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(
                    function success(position){
                        let coords = position.coords;
                        this.lat = coords.latitude;
                        this.lng = coords.longitude;
                    }.bind(this),
                    function error(error){
                        alert('位置情報が取得できません'+error.code);
                    }
                );
            };
        },
    }
</script>
