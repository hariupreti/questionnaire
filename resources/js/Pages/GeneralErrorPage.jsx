import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';

export default function GeneralErrorPage({ props }) {
    const pageProps = usePage().props;

    return (
        <GuestLayout>
            <Head title="Something went wrong" />
            <div className="container mx-auto sm:px-6 lg:px-8 overflow-hidden p-8 bg-red-300 my-40 text-center">
                { pageProps.message ?? "Something went wrong while processing your request" }
            </div>
        </GuestLayout >
    );
}
