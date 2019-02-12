private static function getId_featureFilterSubQuery($filter_value, $ignore_join = false)
	{
		if (empty($filter_value))
			return array();
		$query_filters = ' AND EXISTS (SELECT * FROM '._DB_PREFIX_.'feature_product fp WHERE fp.id_product = p.id_product AND (';
		foreach ($filter_value as $filter_val)
			$query_filters .= 'fp.`id_feature_value` = '.(int)$filter_val.' OR ';
		$query_filters = rtrim($query_filters, 'OR ').')) ';

		return array('where' => $query_filters);
	}
  
	private static function getId_attribute_groupFilterSubQuery($filter_value, $ignore_join = false)
	{
		if (empty($filter_value))
			return array();

		// fix lebo sa niekedy zobrazovali zle hodnoty vo filroch
		$query_filters = '
		AND EXISTS (SELECT *
		FROM `'._DB_PREFIX_.'product_attribute_combination` pac
		LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (pa.`id_product_attribute` = pac.`id_product_attribute`)
		LEFT JOIN '._DB_PREFIX_.'stock_available sa ON (sa.id_product_attribute = pa.id_product_attribute)
		WHERE pa.id_product = p.id_product 
			AND sa.quantity > 0
			AND (';

		foreach ($filter_value as $filter_val)
			$query_filters .= 'pac.`id_attribute` = '.(int)$filter_val.' OR ';
		$query_filters = rtrim($query_filters, 'OR ').')) ';

		return array('where' => $query_filters);
	}
