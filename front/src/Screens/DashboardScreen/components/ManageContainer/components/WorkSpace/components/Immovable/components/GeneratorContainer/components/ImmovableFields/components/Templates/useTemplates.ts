import { useCallback, useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../store/types';
import reqImmovableTemplate from '../../../../../../../../../../../../../../services/generator/Immovable/reqImmovableTemplate';

type InitialData = {
  bank_template_id: number | null,
  taxes_template_id: number | null,
  contract_template_id: number | null,
  questionnaire_template_id: number | null,
  statement_template_id: number | null,
  statement_templates?: SelectItem[],
  questionnaire_templates?: SelectItem[],
  bank_templates?: SelectItem[],
  taxes_templates?: SelectItem[],
  contract_templates?: SelectItem[],
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useTemplates = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  // Initial data
  const [statementTemplates, setStatementTemplates] = useState<SelectItem[]>([]);
  const [questionnaireTemplates, setQuestionnaireTemplates] = useState<SelectItem[]>([]);
  const [bankTemplates, setBankTemplates] = useState<SelectItem[]>([]);
  const [taxesTemplates, setTaxesTemplates] = useState<SelectItem[]>([]);
  const [contractTemplates, setContractTemplates] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    contract_template_id: null,
    taxes_template_id: null,
    bank_template_id: null,
    questionnaire_template_id: null,
    statement_template_id: null,
  });

  const onClear = useCallback(() => {
    setData({
      contract_template_id: null,
      taxes_template_id: null,
      bank_template_id: null,
      questionnaire_template_id: null,
      statement_template_id: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const { success, message } = await reqImmovableTemplate(token, id, 'PUT', data);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, token]);

  useEffect(() => {
    setData({
      contract_template_id: initialData?.contract_template_id || null,
      taxes_template_id: initialData?.taxes_template_id || null,
      bank_template_id: initialData?.bank_template_id || null,
      questionnaire_template_id: initialData?.questionnaire_template_id || null,
      statement_template_id: initialData?.statement_template_id || null,
    });
  }, [initialData]);

  return {
    data,
    statementTemplates,
    questionnaireTemplates,
    bankTemplates,
    taxesTemplates,
    contractTemplates,
    setData,
    onClear,
    onSave,
  };
};
