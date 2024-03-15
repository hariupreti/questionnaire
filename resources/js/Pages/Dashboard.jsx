import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Modal from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import { ImStarEmpty } from "react-icons/im";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";

export default function Dashboard({ auth }) {
    const [showModal, setShowModal] = useState({
        show: false
    });
    const [startDate, setStartDate] = useState(new Date());
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        expiry_date: '',
    });
    useEffect(() => {
        return () => {
            reset('name');
            reset('expiry_date');
        };
    }, []);
    const submit = (e) => {
        e.preventDefault();
        // post(route('login'));
    };
    const showModelView = (e) => {
        setShowModal({
            show: true
        });
    }
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div>
                        <Modal show={showModal.show} onClose={() => setShowModal({ show: false })}>
                            <div className='p-4'>
                                <div className='text-lg font-bold text-left text-gray-800 pb-4 border-b-2 border-gray-300'>
                                    Create new questionnaire
                                </div>
                                <form onSubmit={() => null}>
                                    <div className='mt-10'>
                                        <InputLabel htmlFor="name" value="Title" />
                                        <TextInput
                                            id="name"
                                            type="name"
                                            name="name"
                                            value={data.name}
                                            className="mt-1 block w-full ring-0 outline-none border-gray-300 border p-2"
                                            isFocused={true}
                                            onChange={(e) => setData('name', e.target.value)}
                                        />
                                        <InputError message={errors.name} className="mt-2" />
                                    </div>
                                    <div className="mt-6">
                                    <InputLabel htmlFor="expiryDate" value="Expiry Date" />
                                    <DatePicker className='inline-block flex-initial w-full outline-none focus:outline-none ring-0 focus:ring-0 overflow-hidden rounded-md border-gray-200 ' name='expiryDate' id='expiryDate' selected={startDate} onChange={(date) => setStartDate(date)} />
                                    </div>
                                    <div className='grid w-full my-8'>
                                        <strong>Questions and Answers</strong><br></br>
                                        <p className='-mt-6 text-slate-600'>While saving questionnaire entry, random questions from our records will be applied for newly generated questionnaire.</p>
                                    </div>
                                    <div className="flex items-start justify-end mt-10">
                                        <PrimaryButton className="" disabled={processing}>
                                            Generate
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </Modal>
                    </div>
                    <div className="grid grid-flow-col shadow-sm sm:rounded-lg">
                        <div className="p-4 text-gray-900 font-semibold">List of Questionnaires</div>
                        <div className='flex place-content-end'>
                            <button onClick={(e) => showModelView(e)} className='inline-flex items-center px-4 py-2 m-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'>Create New</button>
                        </div>
                    </div>

                    <div className='grid container mx-auto place-content-center my-20'>
                        <div className='flex place-content-center text-5xl'><ImStarEmpty></ImStarEmpty></div>
                        <h className="my-8">There is no any questionnare yet!!!</h>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
