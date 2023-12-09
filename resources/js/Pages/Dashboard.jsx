import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router, useForm } from "@inertiajs/react";
import { useState, useEffect } from "react";
import { Button, Input } from "@material-tailwind/react";

export default function Dashboard(props) {
    const { data, setData, post, processing, errors } = useForm({
        title: "",
        content: "",
        image: "",
    });

    const [article, setArticle] = useState(props.data.data);
    console.log("props", props.data.data);

    useEffect(() => {
        setArticle(props.data.data);
    }, [props.data.data]);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setData((data) => ({
            ...data,
            [name]: value,
        }));
    };

    const handleImageChange = (event) => {
        const file = event.target.files[0];
        setData((data) => ({
            ...data,
            image: file,
        }));

        // const reader = new FileReader();
        // reader.onloadend = () => {
        //     setPreviewImage(reader.result);
        // };
        // if (file) {
        //     reader.readAsDataURL(file);
        // }
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        const fileName = data.image.name;

        const title = data.title;
        const content = data.content;
        // const image = data.image;

        // const articleData = {
        //     title,
        //     content,
        //     image,
        // };
        const formData = new FormData();

        formData.append("title", data.title);
        formData.append("content", data.content);
        formData.append("image", data.image);

        router.post(route("add.dashboard"), formData);
    };

    function truncateText(text, maxLength) {
        if (text.length <= maxLength) {
            return text;
        }
        return text.substring(0, maxLength) + "...";
    }

    console.log(props.data);
    return (
        <AuthenticatedLayout user={props.auth.user}>
            <Head title="Dashboard" />
            <h1 className="text-center text-black font-bold text-2xl">
                Dashboard
            </h1>
            <form onSubmit={handleSubmit}>
                <div className="flex px-12 py-6 w-full flex-col items-start gap-2">
                    <h2 className="text-gray-500">Masukkan Judul Artikel</h2>
                    <Input
                        color="orange"
                        label="Judul Artikel"
                        className="focus:ring-0"
                        id="title"
                        name="title"
                        onChange={handleInputChange}
                    />
                    <h2 className="text-gray-500">Masukkan Konten Artikel</h2>
                    <Input
                        color="orange"
                        label="Konten Artikel"
                        className="focus:ring-0"
                        id="content"
                        name="content"
                        onChange={handleInputChange}
                    />
                    <h2 className="text-gray-500">Masukkan Gambar</h2>
                    {/* <Input
                        color="orange"
                        label="Gambar Artikel"
                        className="focus:ring-0"
                        id="image"
                        name="image"
                        onChange={handleInputChange}
                    /> */}
                    <input
                        type="file"
                        className="file-input file-input-bordered file-input-warning w-full"
                        data-theme="light"
                        onChange={handleImageChange}
                    />
                    <button className="btn btn-warning btn-sm w-40 h-10 text-white mt-4">
                        Submit
                    </button>
                </div>
            </form>

            <h1 className="text-center text-black font-bold text-2xl">
                Data Artikel
            </h1>

            <div className="content px-12 pt-16 flex flex-wrap justify-center items-center gap-6">
                {article.map((data, i) => {
                    return (
                        <div
                            className="card w-96 bg-white-100 text-black shadow-xl"
                            key={i}
                        >
                            <figure className="h-48">
                                <img src={data.image} alt="Shoes" />
                            </figure>
                            <div className="card-body">
                                <h2 className="card-title">
                                    {truncateText(data.title, 22)}
                                    <div className="badge badge-secondary text-white">
                                        NEW
                                    </div>
                                </h2>
                                <p>{truncateText(data.content, 20)}</p>
                                <div className="card-actions justify-end">
                                    <div className="badge badge-outline">
                                        <Link
                                            href={route("edit.dashboard")}
                                            method="get"
                                            data={{ id: data.id }}
                                            as="button"
                                            
                                        >
                                            Edit
                                        </Link>
                                    </div>
                                    <div className="badge badge-outline">
                                        <button className="hover:bg-sky-700">
                                            <a href={`/delete/${data.id}`}>
                                                Delete
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    );
                })}
            </div>
        </AuthenticatedLayout>
    );
}
