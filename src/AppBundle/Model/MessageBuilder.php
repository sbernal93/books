<?php

/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 8/4/2015
 * Time: 10:39 AM
 */



namespace AppBundle\Model;

use Symfony\Component\Form\Form;
use AppBundle\Entity\Book;

class MessageBuilder
{
    public static function getFormErrorMessages(Form $form)
    {
        $errors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $errors = $error->getMessage();
        }

        return $errors;
    }

    /**
     * Builds the return string when finding one book
     *
     * @param $book Book
     *
     * @return string
     */
    public static function getFindOneBookReturnMessage($book)
    {
        $formattedResponse = "<p>ISBN 10: " . $book->getIsbn10() . "<br />
                ISBN 13: " . $book->getIsbn13() . "</p>
                <p>T&iacute;tulo: <strong>" . $book->getTitle() . "</strong></p>
                <p>Autor: " . $book->getAuthors() . "</p>
                <p>Publicado por: " . $book->getPublisher() . "</p>
                <p>Descripci&oacute;n: " . $book->getDescription() . "</p>
                <p>N&uacute;mero de p&aacute;ginas: " . $book->getPageCount() . "</p>";
        if($book->getImageLink() != 'N/A' && $book->getImageLink() != '')
        {

            $formattedResponse = $formattedResponse.
                "<p><a href='" . $book->getImageLink() . "'>Ver Im&aacute;gen</a></p>";
        }
        else
        {
            $formattedResponse = $formattedResponse. "<p>Imagen No Disponible";
        }


        return $formattedResponse;

    }

    public static function getUploaderReturnMessage($filename)
    {
        $message = '<strong>Documento guardado como: '. $filename .', lo puede conseguir
            en la parte de Descarga de Archivos</strong>';
        return $message;
    }

    public static function getBookNotFoundExceptionMessage()
    {
        return '<strong>No se consigui&oacute; el libro buscado</strong>';
    }
}