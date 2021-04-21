import { useCallback, useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../utils/formatDates';
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
  type_id: number | null,
  ready: boolean,
  sign_date: any,
  final_sign_date: any,
  contract_type?: SelectItem[],
  statement_templates?: SelectItem[],
  questionnaire_templates?: SelectItem[],
  bank_templates?: SelectItem[],
  taxes_templates?: SelectItem[],
  contract_templates?: any,
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useTemplates = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  // Initial data
  const [contractType, setContractType] = useState<SelectItem[]>([]);
  const [statementTemplates, setStatementTemplates] = useState<SelectItem[]>([]);
  const [questionnaireTemplates, setQuestionnaireTemplates] = useState<SelectItem[]>([]);
  const [bankTemplates, setBankTemplates] = useState<SelectItem[]>([]);
  const [taxesTemplates, setTaxesTemplates] = useState<SelectItem[]>([]);
  const [contractTemplates, setContractTemplates] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    type_id: null,
    contract_template_id: null,
    taxes_template_id: null,
    bank_template_id: null,
    questionnaire_template_id: null,
    statement_template_id: null,
    ready: false,
    sign_date: null,
    final_sign_date: null,
  });

  const onClear = useCallback(() => {
    setData({
      type_id: null,
      contract_template_id: null,
      taxes_template_id: null,
      bank_template_id: null,
      questionnaire_template_id: null,
      statement_template_id: null,
      ready: false,
      sign_date: null,
      final_sign_date: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        sign_date: formatDate(new Date(data.sign_date)),
        final_sign_date: formatDate(new Date(data.final_sign_date)),
      };

      const { success, message } = await reqImmovableTemplate(token, id, 'PUT', reqData);
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
    setContractType(initialData?.contract_type || []);
    setStatementTemplates(initialData?.statement_templates || []);
    setQuestionnaireTemplates(initialData?.questionnaire_templates || []);
    setBankTemplates(initialData?.bank_templates || []);
    setTaxesTemplates(initialData?.taxes_templates || []);
    setContractTemplates(initialData?.contract_templates || []);
    setData({
      type_id: initialData?.type_id || null,
      contract_template_id: initialData?.contract_template_id || null,
      taxes_template_id: initialData?.taxes_template_id || null,
      bank_template_id: initialData?.bank_template_id || null,
      questionnaire_template_id: initialData?.questionnaire_template_id || null,
      statement_template_id: initialData?.statement_template_id || null,
      ready: initialData?.ready || false,
      sign_date: initialData?.sign_date
        ? new Date(changeMonthWitDate(initialData?.sign_date)) : null,
      final_sign_date: initialData?.final_sign_date
        ? new Date(changeMonthWitDate(initialData?.final_sign_date)) : null,
    });
  }, [initialData]);

  useEffect(() => {
    if (initialData?.contract_templates) {
      setContractTemplates(initialData?.contract_templates
        .filter((item: any) => item.type_id === data.type_id));
    }
  }, [data.type_id, initialData?.contract_templates]);

  return {
    data,
    contractType,
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
