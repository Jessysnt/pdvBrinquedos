SELECT f.id, SUM(f.subtotal) as total, MAX(f.`pgto1+2`) FROM (
SELECT cf.id, 
	CASE WHEN cf.pg_forma1 IS NOT NULL THEN 
		CASE WHEN  cf.pg_forma1 = 1 THEN 'DINHEIRO'
			 WHEN  cf.pg_forma1 = 2 THEN 'PIX'
             WHEN  cf.pg_forma1 = 3 THEN 'DÉBITO'
             WHEN  cf.pg_forma1 = 4 THEN 'CRÉDITO'
		END
	END
    as f_pgto1, 
	CASE WHEN cf.pg_forma2 IS NOT NULL THEN 
		CASE WHEN  cf.pg_forma2 = 1 THEN 'DINHEIRO'
			 WHEN  cf.pg_forma2 = 2 THEN 'PIX'
             WHEN  cf.pg_forma2 = 3 THEN 'DÉBITO'
             WHEN  cf.pg_forma2 = 4 THEN 'CRÉDITO'
		END
	END
    as f_pgto2,
    cf.valor_total1 as v_pgto1,
    cf.valor_total2 as v_pgto2,
    cf.vzs_cartao,
    cf.bandeira_cartao,
    CASE WHEN lf.desconto IS NOT NULL THEN (lf.quantidade*lf.valor_unitario-lf.desconto) ELSE (lf.quantidade*lf.valor_unitario) END as subtotal,
    CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END as 'pgto1+2'
FROM comandafatura as cf 
INNER JOIN linhafatura as lf ON cf.id = lf.id_comanda_fatura
) as f
-- WHERE (CASE WHEN lf.desconto IS NOT NULL THEN (lf.quantidade*lf.valor_unitario-lf.desconto) ELSE (lf.quantidade*lf.valor_unitario) END) = (CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END)
GROUP BY f.id;