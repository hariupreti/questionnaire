import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';

export default function Test({ props }) {
    const pageProps = usePage().props;
    const [answerData, setAnswerData] = useState([]);

    const setQuestionAnswer = (questionId, answerId) => {
        setAnswerData(answerData =>
            answerData.filter(item => !(item.qid === questionId))
        );
        setAnswerData(answerData => [...answerData, { 'qid': questionId, 'aid': answerId }])
    };

    const saveStudentAnswer = () => {
        router.post(route('save.answers'), {
            "questionnaireId": pageProps.questionnaire.id ?? 0,
            "studentId": pageProps.student.id ?? 0,
            "answerData": answerData
        },
            {
                onSuccess: () => alert("Test submited successfully!!!")
            });
    }

    return (
        <GuestLayout>
            <Head title="Welcome to Questionnaire" />
            <div className="container mx-auto sm:px-6 lg:px-8 overflow-hidden">
                {pageProps.questionnaire && pageProps.questionnaire.id > 0 &&
                    <div className=' w-screen grid grid-flow-col grid-cols-12 pb-6 pt-4 bg-white fixed top-0 place-content-center container mx-auto'>
                        <div className='col-span-6'>
                            <strong className='text-slate-800 text-lg'> {pageProps.questionnaire.title}</strong><br></br>
                            <span className='text-xs font-thin'>Valid till: {pageProps.questionnaire.expiry_date}</span>
                        </div>
                        <div className='col-span-6'>
                            <button onClick={(e) => saveStudentAnswer()} className='float-right bg-slate-700 p-2 mt-2 rounded-md hover:bg-slate-800 font-semibold text-white'>Submit Answer</button>
                        </div>
                    </div>
                }
                <div className='mt-32 pt-10 border-t-2 border-gray-200'>
                    {
                        pageProps.questions.map((eachQuestion, index) => {
                            return <React.Fragment key={index}>
                                <h1>{++index}. {eachQuestion.question_text}</h1>
                                <div className='min-h-20 w-fit grid grid-flow-col grid-cols-12 gap-4 py-10'>
                                    {
                                        eachQuestion.answers && eachQuestion.answers.map((eachAnswer, ansIndex) => {
                                            let activeClassClass = answerData.some(eachData => eachData.qid === eachQuestion.id && eachData.aid === eachAnswer.id) ? "bg-slate-600 text-white" : "bg-slate-100";
                                            return <div onClick={(e) => setQuestionAnswer(eachQuestion.id, eachAnswer.id)}
                                                key={"QA" + index + "-" + ansIndex}
                                                className={`col-span-3 bg-gray-100 hover:bg-gray-200 delay-150 duration-200 transition-all rounded-sm cursor-pointer p-8 font-semibold ${activeClassClass}`}>
                                                {eachAnswer.answer_text}
                                            </div>
                                        })
                                    }
                                </div>
                            </React.Fragment>
                        })
                    }
                </div>
            </div>
        </GuestLayout >
    );
}
