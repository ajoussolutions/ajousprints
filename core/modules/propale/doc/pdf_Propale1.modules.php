<?php


require_once DOL_DOCUMENT_ROOT.'/core/modules/product/modules_product.class.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
require_once DOL_DOCUMENT_ROOT.'/fourn/class/fournisseur.product.class.php';
require_once DOL_DOCUMENT_ROOT.'/custom/ajousprints/functions/utils.php';


/**
 *	Class to build documents using ODF templates generator
 */
class pdf_Propale1 extends CommonDocGenerator
{
	/**
	 * @var DoliDB Database handler
	 */
	public $db;

	/**
	 * @var string model name
	 */
	public $name;

	/**
	 * @var string model description (short text)
	 */
	public $description;

	/**
	 * @var string document type
	 */
	public $type;

	/**
	 * Dolibarr version of the loaded document
	 * @var string
	 */
	public $version = 'dolibarr';


	/**
	 *	Constructor
	 *
	 *  @param		DoliDB		$db      Database handler
	 */
	public function __construct($db)
	{
		global $langs, $mysoc;

		// Load traductions files required by page
		$langs->loadLangs(array("main", "companies"));

		$this->db = $db;
		$this->name = "Propale1";
		$this->description = $langs->trans("DocumentModelStandardPDF");

	}


	/**
	 *	Function to build a document on disk using the generic odt module.
	 *
	 *	@param		Product		$object				Object source to build document
	 *	@param		Translate	$outputlangs		Lang output object
	 * 	@param		string		$srctemplatepath	Full path of source filename for generator using a template file
	 *  @param		int			$hidedetails		Do not show line details
	 *  @param		int			$hidedesc			Do not show desc
	 *  @param		int			$hideref			Do not show ref
	 *	@return		int         					1 if OK, <=0 if KO
	 */
	public function write_file($object, $outputlangs, $srctemplatepath, $hidedetails = 0, $hidedesc = 0, $hideref = 0)
	{
		// phpcs:enable
		global $user, $langs, $conf, $mysoc, $db, $hookmanager;
        $data=new stdClass();
        $data->propale=$object;
        $path = $conf->propal->multidir_output[$object->entity].'/'.$object->ref.'/'.$object->ref.'.pdf';
        $result = savePdf($data,'propale',$path,['paperWidth'=>"210mm",'paperHeight'=>"297mm",'marginTop'=>0,'marginBottom'=>0,'marginLeft'=>0,'marginRight'=>0]);

		return $result;
	}

}
