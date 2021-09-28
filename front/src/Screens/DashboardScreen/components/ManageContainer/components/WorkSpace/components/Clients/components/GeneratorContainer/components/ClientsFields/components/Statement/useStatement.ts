import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect } from 'react';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../utils/formatDates';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import reqClientConsents from '../../../../../../../../../../../../../../services/generator/Client/reqClientConsents';

type InitialData = {
  notary_id: string,
  consent_template_id: string,
  married_type_id: string,
  mar_series: string,
  mar_series_num: string,
  mar_date: any,
  mar_depart: string,
  mar_reg_num: string,
  sign_date: any,
  reg_num: string,
  duplicate: boolean,
  duplicate_date: any,
  widow: boolean,
  widow_date: any,
  consent_spouse_word_id: string,
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
    consent_spouse_word_id: '',
    duplicate: false,
    duplicate_date: null,
    widow: false,
    widow_date: null,
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
      mar_date: initialData?.mar_date ? changeMonthWitDate(initialData?.mar_date) : null,
      mar_depart: initialData?.mar_depart || '',
      mar_reg_num: initialData?.mar_reg_num || '',
      sign_date: initialData?.sign_date
        ? changeMonthWitDate(initialData?.sign_date) : null,
      reg_num: initialData?.reg_num || '',
      consent_spouse_word_id: initialData?.consent_spouse_word_id || '',
      duplicate: initialData?.duplicate || false,
      duplicate_date: initialData?.duplicate_date || null,
      widow: initialData?.widow || false,
      widow_date: initialData?.widow_date || null,
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
      consent_spouse_word_id: '',
      duplicate: false,
      duplicate_date: null,
      widow: false,
      widow_date: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        mar_date: formatDate(data.mar_date),
        sign_date: formatDate(data.sign_date),
        widow_date: formatDate(data.widow_date),
        duplicate_date: formatDate(data.duplicate_date),
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
  }, [clientId, data, dispatch, personId, token]);

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
