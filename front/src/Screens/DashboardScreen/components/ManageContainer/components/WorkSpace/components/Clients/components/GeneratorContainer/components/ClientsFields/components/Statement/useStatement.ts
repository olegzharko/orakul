import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import reqClientConsents from '../../../../../../../../../../../../../../services/generator/Client/reqClientConsents';
import { formatDate } from '../../../../../../../../../../../../../../utils/formatDates';

type InitialData = {
  notary_id: string,
  consent_template_id: string,
  married_type_id: string,
  mar_series: string,
  mar_series_num: string,
  mar_date: Date | null,
  mar_depart: string,
  mar_reg_num: string,
  sign_date: Date | null,
  reg_num: string,
  consent_spouse_words_id: string,
  notary?: SelectItem[],
  consent_templates?: SelectItem[],
  married_types?: SelectItem[],
  consent_spouse_words?: SelectItem[],
}

export type Props = {
  clientId: string;
  personId: string;
  initialData?: InitialData;
}

export const useStatement = ({ initialData, clientId, personId }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [rakulNotary, setRakulNotary] = useState<SelectItem[]>([]);
  const [consentTemplates, setConsentTemplates] = useState<SelectItem[]>([]);
  const [marriageTypes, setMarriageTypes] = useState<SelectItem[]>([]);
  const [consentSpouseWords, setConsentSpouseWords] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    notary_id: '',
    consent_template_id: '',
    married_type_id: '',
    mar_series: '',
    mar_series_num: '',
    mar_date: null,
    mar_depart: '',
    mar_reg_num: '',
    sign_date: null,
    reg_num: '',
    consent_spouse_words_id: '',
  });

  useEffect(() => {
    setRakulNotary(initialData?.notary || []);
    setConsentTemplates(initialData?.consent_templates || []);
    setMarriageTypes(initialData?.married_types || []);
    setConsentSpouseWords(initialData?.consent_spouse_words || []);
    setData({
      notary_id: initialData?.notary_id || '',
      consent_template_id: initialData?.consent_template_id || '',
      married_type_id: initialData?.married_type_id || '',
      mar_series: initialData?.mar_series || '',
      mar_series_num: initialData?.mar_series_num || '',
      mar_date: initialData?.mar_date ? new Date(initialData?.mar_date) : null,
      mar_depart: initialData?.mar_depart || '',
      mar_reg_num: initialData?.mar_reg_num || '',
      sign_date: initialData?.sign_date ? new Date(initialData?.sign_date) : null,
      reg_num: initialData?.reg_num || '',
      consent_spouse_words_id: initialData?.consent_spouse_words_id || '',
    });
  }, [initialData]);

  const onClear = useCallback(() => {
    setData({
      notary_id: '',
      consent_template_id: '',
      married_type_id: '',
      mar_series: '',
      mar_series_num: '',
      mar_date: null,
      mar_depart: '',
      mar_reg_num: '',
      sign_date: null,
      reg_num: '',
      consent_spouse_words_id: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        mar_date: data.mar_date ? formatDate(data.mar_date) : null,
        sign_date: data.sign_date ? formatDate(data.sign_date) : null,
      };

      const { success, message } = await reqClientConsents(token, clientId, personId, 'PUT', reqData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, token]);

  return {
    data,
    rakulNotary,
    consentTemplates,
    marriageTypes,
    consentSpouseWords,
    setData,
    onClear,
    onSave,
  };
};
