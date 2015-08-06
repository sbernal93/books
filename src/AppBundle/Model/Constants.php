<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 8/4/2015
 * Time: 10:42 AM
 */

namespace AppBundle\Model;

class Constants
{
    /**
     * ################################################################################################################
     *                                          Google Books API Info
     * ################################################################################################################
     */
    const GOOGLE_BOOKS_QUERY            =   'isbn:';
    const GOOGLE_BOOKS_LABEL_INDUSTRY   =   'industryIdentifiers';
    const GOOGLE_BOOKS_LABEL_IDENTIFIER =   'identifier';
    const GOOGLE_BOOKS_LABEL_AUTHORS    =   'authors';
    const GOOGLE_BOOKS_LABEL_MODELDATA  =   'modelData';
    const GOOGLE_BOOKS_LABEL_IMAGELINKS =   'imageLinks';
    const GOOGLE_BOOKS_LABEL_THUMBNAIL  =   'thumbnail';
    const GOOGLE_BOOKS_LABEL_TITLE      =   'title';
    const GOOGLE_BOOKS_LABEL_PUBLISHER  =   'publisher';
    const GOOGLE_BOOKS_LABEL_DESCRIPTION=   'description';
    const GOOGLE_BOOKS_LABEL_PAGECOUNT  =   'pageCount';
    const GOOGLE_BOOKS_LABEL_API_KEY    =   'api_key';
    const GOOGLE_BOOKS_LABEL_LANGRES    =   'langRestrict';
    const GOOGLE_BOOKS_LANGRESTRICT     =   'es';

    /**
     * ################################################################################################################
     *                                          Excel Info
     * ################################################################################################################
     */
    const EXCEL_CREATOR                 =   'Linio Books';
    const EXCEL_LASTMODIFIED            =   'Linio Books';
    const EXCEL_TITLE                   =   'Linio Books Search Results';
    const EXCEL_SUBJECT                 =   'Books';
    const EXCEL_DESCRIPTION             =   'Linio Books Search Results Powered by Google';
    const EXCEL_KEYWORDS                =   'office 2007 books';
    const EXCEL_CATEGORY                =   'Search Result File';
    const EXCEL_CELL_A1                 =   'ISBN_10';
    const EXCEL_CELL_B1                 =   'ISBN_13';
    const EXCEL_CELL_C1                 =   'Titulo';
    const EXCEL_CELL_D1                 =   'Autor';
    const EXCEL_CELL_E1                 =   'Editorial';
    const EXCEL_CELL_F1                 =   'Descripcion';
    const EXCEL_CELL_G1                 =   'Numero de Paginas';
    const EXCEL_CELL_H1                 =   'Imagen';
    const EXCEL_DOWNLOAD_LOCATION       =   'http://books.linio/upload/';

    /**
     * ################################################################################################################
     *                                          Book table database info
     * ################################################################################################################
     */
    const BOOK_TABLE                    =   'linio_books';
    const BOOK_ID                       =   'LB_id';
    const BOOK_ISBN10                   =   'LB_isbnTen';
    const BOOK_ISBN13                   =   'LB_isbnThirteen';
    const BOOK_TITLE                    =   'LB_title';
    const BOOK_PUBLISHER                =   'LB_publisher';
    const BOOK_DESCRIPTION              =   'LB_description';
    const BOOK_NUMPAGES                 =   'LB_pages';
    const BOOK_IMAGELINK                =   'LB_imageLink';
    const AUTHOR_NAME                   =   'auth_name';

}