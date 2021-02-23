<template>
    <div>
        <div class="bg-blue-400 h-screen w-screen">
            <div
                class="flex flex-col items-center flex-1 h-full justify-center px-4 sm:px-0"
            >
                <div
                    class="flex rounded-lg shadow-lg w-full sm:w-3/4 lg:w-1/2 bg-white sm:mx-0"
                    style="height: 500px"
                >

                    <div
                        class="hidden md:block md:w-1/2 rounded-l-lg"
                        style="
                            background: url('/images/login.jpg');
                            background-size: cover;
                            background-position: center center;
                        "
                    ></div>

                    <div class="flex flex-col w-full md:w-1/2 p-4">
                        <div class="flex flex-col flex-1 justify-center mb-8">
                            <h1 class="text-4xl text-center font-thin">注册</h1>
                            <div class="w-full mt-4">
                                <form
                                    class="form-horizontal w-3/4 mx-auto"
                                    method="POST"
                                    action="#"
                                >
                                    <div class="flex flex-col mt-4">

                                    </div>
                                    <div class="flex flex-col mt-4">

                                    </div>

                                    <div class="flex flex-col mt-4">

                                    </div>
                                    <div class="flex items-center mt-4">


                                    </div>
                                    <div class="flex flex-col mt-8">

                                    </div>
                                </form>
                                <hd-footer />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HdFooter from "./Footer";
export default {
    route: {path: "/register",meta: { guest: true } },
    components: { HdFooter },
};
</script>

<style></style>
