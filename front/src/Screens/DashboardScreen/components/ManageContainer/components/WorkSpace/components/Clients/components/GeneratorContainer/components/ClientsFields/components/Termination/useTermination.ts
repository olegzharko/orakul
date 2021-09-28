import { useCallback, useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../../../../store/types';
import reqTermination from '../../../../../../../../../../../../../../services/generator/Client/reqTermination';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../utils/formatDates';

type InitialData = {
  spouse_word_id: string | null,
  consent_template_id: string | null,
  notary_id: string | null,
  reg_date: any,
  reg_number: string | null,
  consent_templates?: SelectItem[],
  spouse_words?: SelectItem[],
  notary?: SelectItem[],
}

export type Props = {
  initialData: any;
  clientId: string;
  personId: string;
}

export const useTermination = ({ initialData, clientId, personId }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  // pickers
  const [consentTemplates, setConsentTemplates] = useState<SelectItem[]>([]);
  const [spouseWords, setSpouseWords] = useState<SelectItem[]>([]);
  const [notaries, setNotaries] = useState<SelectItem[]>([]);

  const [data, setData] = useState<InitialData>({
    spouse_word_id: null,
    consent_template_id: null,
    notary_id: null,
    reg_date: null,
    reg_number: null,
  });

  useEffect(() => {
    setConsentTemplates(initialData?.consent_templates || []);
    setSpouseWords(initialData?.spouse_words || []);
    setNotaries(initialData?.notary || []);
    setData({
      spouse_word_id: initialData?.spouse_word_id || null,
      consent_template_id: initialData?.consent_template_id || null,
      notary_id: initialData?.notary_id || null,
      reg_number: initialData?.reg_number || null,
      reg_date: initialData?.reg_date ? changeMonthWitDate(initialData?.reg_date) : null,
    });
  }, [initialData]);

  const onClear = useCallback(() => {
    setData({
      spouse_word_id: null,
      consent_template_id: null,
      notary_id: null,
      reg_date: null,
      reg_number: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const bodyData = {
        ...data,
        reg_date: formatDate(data.reg_date),
      };

      const { success, message } = await reqTermination(token, clientId, personId, 'PUT', bodyData);
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
    consentTemplates,
    spouseWords,
    notaries,
    setData,
    onClear,
    onSave,
  };
};
