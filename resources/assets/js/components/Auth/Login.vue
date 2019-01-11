<template>
    <section class="login">
        <auth-header></auth-header>
        <div class="container">
            <div class="row justify-content-center align-items-center h-100vh">

                <form @submit.prevent="login(credentials)" class="col-4">
                    <div class="login-form">

                        <div class="form-group">
                            <input type="text"
                                   placeholder="Почта"
                                   class="form-control"
                                   autofocus
                                   v-model="credentials.email"
                                   >
                        </div>
                        <div class="form-group">
                            <input type="password"
                                   placeholder="Пароль"
                                   class="form-control"
                                   v-model="credentials.password"
                                   >
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="col-md-8 mx-auto">
                            <button type="submit" class="primary-button col-md-12">Войти</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>

</template>

<script>
    import { mapActions } from 'vuex'
    import others from '../../services/others'
    import AuthHeader from './Partials/AuthHeader'

    export default {
        data() {
            return {
                others,
                credentials: {
                    email: '',
                    password: ''
                }
            }
        },

        components: {
            AuthHeader
        },

        created () {
            this.clear()
            others.all()
        },

        methods: {
            ...mapActions({
                login: 'auth/login'
            }),

            clear () {
                if (!this._securityOrigin)
                {
                  return;
                }

                const storageTypes = [];
                for (const type of this._settings.keys()) {
                  if (this._settings.get(type).get())
                    storageTypes.push(type);
                }

                this._target.storageAgent().clearDataForOrigin(this._securityOrigin, storageTypes.join(','));

                const set = new Set(storageTypes);
                const hasAll = set.has(Protocol.Storage.StorageType.All);
                if (set.has(Protocol.Storage.StorageType.Cookies) || hasAll) {
                  const cookieModel = this._target.model(SDK.CookieModel);
                  if (cookieModel)
                    cookieModel.clear();
                }

                if (set.has(Protocol.Storage.StorageType.Indexeddb) || hasAll) {
                  for (const target of SDK.targetManager.targets()) {
                    const indexedDBModel = target.model(Resources.IndexedDBModel);
                    if (indexedDBModel)
                      indexedDBModel.clearForOrigin(this._securityOrigin);
                  }
                }

                if (set.has(Protocol.Storage.StorageType.Local_storage) || hasAll) {
                    const storageModel = this._target.model(Resources.DOMStorageModel);
                    if (storageModel)
                      storageModel.clearForOrigin(this._securityOrigin);
                }

                if (set.has(Protocol.Storage.StorageType.Websql) || hasAll) {
                  const databaseModel = this._target.model(Resources.DatabaseModel);
                  if (databaseModel) {
                    databaseModel.disable();
                    databaseModel.enable();
                  }
                }

                if (set.has(Protocol.Storage.StorageType.Cache_storage) || hasAll) {
                    const target = SDK.targetManager.mainTarget();
                    const model = target && target.model(SDK.ServiceWorkerCacheModel);
                    if (model)
                      model.clearForOrigin(this._securityOrigin);
                    }

                if (set.has(Protocol.Storage.StorageType.Appcache) || hasAll) {
                  const appcacheModel = this._target.model(Resources.ApplicationCacheModel);
                  if (appcacheModel)
                    appcacheModel.reset();
                }

                this._clearButton.disabled = true;
                const label = this._clearButton.textContent;
                this._clearButton.textContent = Common.UIString('Clearing...');
                setTimeout(() => {
                  this._clearButton.disabled = false;
                  this._clearButton.textContent = label;
                }, 500);
            }
        }

    }
</script>
