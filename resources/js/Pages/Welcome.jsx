import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link, Head } from '@inertiajs/react';
import { useState } from 'react';
import Login from './Auth/Login';
import PrimaryButton from '@/Components/PrimaryButton';
import Dropdown from '@/Components/Dropdown';

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    const handleImageError = () => {
        document.getElementById('screenshot-container')?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document.getElementById('docs-card-content')?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };

    const [show, setShow] = useState(true);

    const toggle = (e) => {
        setShow(!show);
    }

    return (
        <>
            <Head title="Welcome" />
            <div className="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
                <div className="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <header className="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                            <div className="shrink-0 flex items-center">
                                <Link href="/">
                                    <ApplicationLogo className="h-40 rounded-none -mt-24 scale-50 absolute -left-2" />
                                </Link>
                            </div>
                            <div className="flex lg:justify-center lg:col-start-2">

                            </div>
                            <nav className="-mx-3 flex flex-1 justify-end">
                                { auth.user ? (
                                    <div className="hidden sm:flex sm:items-center sm:ms-6">
                                        <div className="ms-3 relative">
                                            <Dropdown>
                                                <Dropdown.Trigger>
                                                    <span className="inline-flex rounded-md">
                                                        <button
                                                            type="button"
                                                            className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                                        >
                                                            {auth.user.name}
                                                            <svg
                                                                className="ms-2 -me-0.5 h-4 w-4"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                            >
                                                                <path
                                                                    fillRule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                    clipRule="evenodd"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </Dropdown.Trigger>

                                                <Dropdown.Content>
                                                    <Dropdown.Link href={route('profile.edit')}>Profile</Dropdown.Link>
                                                    <Dropdown.Link href={route('logout')} method="post" as="button">
                                                        Log Out
                                                    </Dropdown.Link>
                                                </Dropdown.Content>
                                            </Dropdown>
                                        </div>
                                    </div>
                                ) : (
                                    <>
                                        {/* <Link
                                            href={route('login')}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Log in
                                        </Link> */}
                                        <Link
                                            href={route('register')}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Create Student Account
                                        </Link>
                                    </>
                                )}
                            </nav>
                        </header>

                        <main className="mt-6 min-h-screen">
                            <div className='w-full bg-slate-200 p-10 rounded'>
                                <h1 className='font-semibold text-lg'>Great to see you here!!!</h1>
                                <p>Proceed futher to login for further setup.</p>
                                <div className='mt-10'>
                                    {
                                        auth.user ?
                                            <div>Hello {auth.user.name.split(' ').slice(-1).join(' ')},<br></br>
                                                Would you like to create or manage quessionnaire from dashboard ?
                                                <div className='w-full grid p-20 place-content-center'>
                                                    <Link href={route('dashboard')} className='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'>Access Dashboard</Link>
                                                </div>
                                            </div>
                                            :
                                            <div><Login></Login><div className='mt-20 text-right'>
                                                <div className='text-lg font-sm'>Searching for credentials ?</div>
                                                <div><span className='text-xs cursor-pointer hover:text-black' onClick={(e) => toggle(e)}>View default admin</span></div>
                                                <div className={`text-xs text-left mt-5 p-8 bg-slate-600 ${show ? "hidden" : "display"}`}>
                                                    <div><strong>Username:</strong> admin@questionnaire.test</div>
                                                    <div><strong>Password:</strong> password</div>
                                                </div>
                                            </div>
                                            </div>}
                                </div>
                                <hr></hr>

                            </div>
                        </main>

                        <footer className="py-16 text-center text-sm text-black dark:text-white/70">
                            Proshore Assessment
                        </footer>
                    </div>
                </div>
            </div>
        </>
    );
}
