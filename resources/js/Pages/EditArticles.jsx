import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, useForm } from "@inertiajs/react";
import { useState, useEffect } from "react";
import { Button, Input, Navbar } from "@material-tailwind/react";

export default function EditArticles(props) {
    const { data, setData, post, processing, errors } = useForm({
        title: props.articles.title,
        content: props.articles.content,
        image: props.articles.image,
    });

    const [article, setArticle] = useState(props.articles);
    const [previewImage, setPreviewImage] = useState();

    // const [files, setFiles] = useState();
    // const [previews, setPreviews] = useState();

    useEffect(() => {
        setArticle(props);
    }, [props]);

    // input change
    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setData((data) => ({
            ...data,
            [name]: value,
        }));
    };

    // image change
    const handleImageChange = (e) => {
        const file = e.target.files[0];
        setData((data) => ({
            ...data,
            image: file,
        }));
        setData((data) => ({
            ...data,
            image: file,
        }));

        const reader = new FileReader();
        reader.onloadend = () => {
            setPreviewImage(reader.result);
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    };

    useEffect(() => {
        setPreviewImage(props.articles.image);
    }, []);

    console.log(props.articles.image)

    // submit article function
    const handleSubmit = (e) => {
        e.preventDefault();

        const formData = new FormData();

        formData.append("title", data.title);
        formData.append("content", data.content);
        formData.append("image", data.image);

        router.post(
            route("update.dashboard", { id: props.articles.id }),
            formData
        );
    };
    return (
        <AuthenticatedLayout user={props.auth.user}>
            <Head title="Dashboard" />
            <h1 className="text-center text-black font-bold text-2xl">
                Edit Artikel
            </h1>
            <form onSubmit={handleSubmit}>
                <div className="flex px-12 py-6 w-full flex-col items-start gap-2">
                    <h2 className="text-gray-500">Masukkan Judul Artikel</h2>
                    <Input
                        color="blue"
                        label="Judul Artikel"
                        className="focus:ring-0"
                        id="title"
                        name="title"
                        onChange={handleInputChange}
                        defaultValue={props.articles.title}
                    />
                    <h2 className="text-gray-500">Masukkan Konten Artikel</h2>
                    <Input
                        color="blue"
                        label="Konten Artikel"
                        className="focus:ring-0"
                        id="content"
                        name="content"
                        onChange={handleInputChange}
                        defaultValue={props.articles.content}
                    />
                    <h2 className="text-gray-500">Masukkan Gambar</h2>
                    <input
                        type="file"
                        accept="image/jpg, image/jpeg, image/png"
                        multiple
                        onChange={handleImageChange}
                        data-theme="light"
                        className="file-input file-input-bordered file-input-primary w-full"
                    />
                    {previewImage && (
                        <div className="mt-2 border-dashed border-2 border-gray-400 p-2">
                            <img    
                                src={previewImage}
                                alt="Thumbnail Preview"
                                className="h-36 w-64 object-cover mx-auto"
                            />
                        </div>
                    )}
                    {/* {previews && previews.map((pic) => {
                        return <img className="h-40 w-40 object-cover" src={pic} />
                    })} */}

                    {/* <input
                        type="file"
                        className="file-input file-input-bordered file-input-primary w-full"
                        data-theme="light"
                        onChange={handleImageChange}
                    /> */}
                    <button className="btn btn-primary btn-sm text-white w-40 h-10 mt-4 ">
                        Update
                    </button>
                </div>
            </form>
        </AuthenticatedLayout>
    );
}
