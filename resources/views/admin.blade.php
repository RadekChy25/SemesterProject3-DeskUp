@extends('layout')
<div class="m-20">
    <x-navbar>
    </x-navbar>
</div>
<div class="flex w-full flex-col lg:flex-row">
    <div class="card bg-base-300 rounded-box grid h-32 flex-grow place-items-center p-8">
        <h2 class="text-3xl">Register new users.</h2>
        <x-login>
        </x-login>
    </div>
    <div class="divider lg:divider-horizontal"></div>
    <div class="card bg-base-300 rounded-box grid h-32 flex-grow place-items-center">
        <h2 class="text-3xl">List of users:</h2>
    </div>
  </div>