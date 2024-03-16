import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Modal from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import { ImStarEmpty } from "react-icons/im";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import Checkbox from '@/Components/Checkbox';

export default function Dashboard({ auth }) {
    const pageProps = usePage().props;
    const [expiryDate, setExpiryDate] = useState(null);
    const [showModal, setShowModal] = useState({
        show: false
    });
    const { data, setData, post, processing, errors, reset } = useForm({
        id: 0,
        title: '',
        selectedExpiryDate: null,
        remember: true,
    });

    useEffect(() => {
        if (expiryDate) {
            setData({ ...data, selectedExpiryDate: new Date(expiryDate).toLocaleDateString("en-US") })
        }
        return () => {
            reset('title');
            reset('expiryDate');
        };
    }, [expiryDate]);

    const submit = (e) => {
        e.preventDefault();
        if (data.id == 0) {
            post(route('questionnaire.save'), {
                onSuccess: () => setShowModal(false),
            });
        } else {
            post(route('questionnaire.update'), {
                onSuccess: () => setShowModal(false),
            });
        }
    };

    const showModelView = (e) => {
        setShowModal({
            show: true
        });
    }

    const editQuestionnaire = (questionnaire) => {
        setExpiryDate(new Date(questionnaire.expiry_date).toLocaleDateString("en-US"));
        setData({
            ...data,
            id: questionnaire.id,
            title: questionnaire.title,
            expiryDate: new Date(questionnaire.expiry_date).toLocaleDateString("en-US"),
            selectedExpiryDate: true
        });

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
                                    {data.id > 0 ? "Update existing" : "Create new"} questionnaire
                                </div>
                                <form onSubmit={(e) => submit(e)}>
                                    <div className='mt-10'>
                                        <InputLabel htmlFor="title" value="Title" className='text-md font-bold' />
                                        <TextInput
                                            id="title"
                                            type="title"
                                            name="title"
                                            value={data.title}
                                            className="mt-1 block w-full ring-0 outline-none border-gray-300 border p-2"
                                            isFocused={true}
                                            onChange={(e) => setData('title', e.target.value)}
                                        />
                                        <InputError message={errors.title} className="mt-2" />
                                    </div>
                                    <div className="mt-6">
                                        <InputLabel htmlFor="expiryDate" value="Expiry Date" className='text-md font-bold' />
                                        <DatePicker className='inline-block flex-initial w-full outline-none focus:outline-none ring-0 focus:ring-0 overflow-hidden rounded-md border-gray-200 ' name='expiryDate' id='expiryDate'
                                            selected={expiryDate}
                                            onChange={(date) => setExpiryDate(date)}
                                            dateFormat="MM/dd/yyyy"
                                        />
                                        <InputError message={errors.selectedExpiryDate} className="mt-2" />
                                    </div>
                                    <div className='grid w-full my-8'>
                                        <strong>Questions and Answers</strong><br></br>
                                        <p className='-mt-6 text-slate-600'>While saving questionnaire entry, random questions from our records will be applied for newly generated questionnaire.</p>
                                    </div>
                                    <div className='grid w-full my-8 border-b-2 border-gray-100 pb-6'>
                                        <strong>Student Enrollment</strong><br></br>
                                        <p className='-mt-6 text-slate-600 text-sm'>It is checked by default, i.e. all of recorded students will notifiy once questionnaire created.</p>
                                        <label className="flex items-center">
                                            <Checkbox
                                                name="remember"
                                                disabled
                                                checked={data.remember}
                                            />
                                            <span className="ms-2 text-sm text-gray-600">Enroll all students</span>
                                        </label>
                                    </div>
                                    <div className="flex items-start justify-end mt-10 mb-10">
                                        <PrimaryButton className="" disabled={processing}>
                                            {data.id > 0 ? "Update" : "Generate"} Questionnaire
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
                    {pageProps.questionnaire && pageProps.questionnaire.length > 0 ?
                        <div className='grid'>
                            {
                                pageProps.questionnaire.map((eachQuestionnaire) => {
                                    return <div key={"eachSeperateQuestionnaire" + eachQuestionnaire.id} className='gird w-full grid-flow-col grid-cols-12 p-4 text-gray-950 bg-gray-200 min-h-14 mt-4 cursor-pointer hover:bg-slate-200 delay-150 duration-300 transition-all'>
                                        <div className='font-semibold col-span-6 float-left'>{eachQuestionnaire.title}</div>
                                        <div className='col-span-6 float-right'>
                                            <button className='bg-primary mr-6 bg-slate-100 border-gray-400 rounded-md px-2 cursor-pointer hover:bg-slate-50' onClick={(e) => editQuestionnaire(eachQuestionnaire)}>Edit</button>
                                            <button className='bg-primary bg-red-500 border-gray-400 rounded-md px-2 cursor-pointer hover:bg-red-600 text-white'>Delete</button>
                                        </div>
                                    </div>
                                })
                            }
                        </div>
                        :
                        <div className='grid container mx-auto place-content-center my-20'>
                            <div className='flex place-content-center text-5xl text-gray-400'><ImStarEmpty></ImStarEmpty></div>
                            <h className="my-8 text-slate-600">There is no any questionnare yet!!!</h>
                            <div className='text-center -mt-6 text-green-500' ><button onClick={(e) => showModelView(e)}>Create one</button></div>
                        </div>
                    }
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
