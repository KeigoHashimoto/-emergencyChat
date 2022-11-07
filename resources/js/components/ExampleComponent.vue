<template>
<div class="col-md-8">
    <div class="message-input mt-3">
        <div class="form">
            <form action="message/ajax/store" method="post">
                <input name="message" v-model="message" class="form-control" placeholder="ここに文章を入力してください">
                <button type="button" @click="send()" class="btn btn-primary mt-2"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
        <div><input type="checkbox" v-model="checked"> 位置情報を登録(チェックを外すと位置情報は送信されません)</div>
        <div class="easy-menu">
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
                <!-- ユーザーの名前 -->
                <div class="user-name">{{ message.user.name }}</div>

                <!-- メッセージ内容 -->
                <div class="self-message-content">{{ message.content }}<br>
                    <span v-if="message.latitude != null">{{ message.latitude }},{{ message.longitude }}</span>
                </div>
                <small>{{ message.created_at.substr(0,[16]) }}</small>
            </div>
            <!-- 自分以外のメッセージ -->
            <div v-else>
                <div class="user-name">{{ message.user.name }}</div>
                <div class="message-content">{{ message.content }}<br>
                    <span v-if="message.latitude != null">{{ message.latitude }},{{ message.longitude }}</span>
                </div>
                <small>{{ message.created_at.substr(0,[16]) }}</small>
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
                // チェックが外れていたら緯度経度はnullで返す
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
            getAuthUser(){
                axios.get('message/ajax/authUser').then((response) => {
                    this.authUser = response.data;
                });
            },
        },
        mounted (){
            this.getMessage();
            this.getAuthUser();

            Echo.channel('chat').listen('CreatedMessage', (e) => {
                this.getMessage();
            });

            // 位置情報の取得
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(
                    function success(position){
                        // 座標
                        let coords = position.coords;
                        // 経度
                        this.lat = coords.latitude;
                        // 緯度
                        this.lng = coords.longitude;
                    }.bind(this),
                    function error(error){
                        this.checked = false;
                        alert('位置情報が取得できません'+error.code);
                        // 位置情報が取得できなかったらチェックを外す
                    }.bind(this)
                );
            }
        },
    }
</script>
