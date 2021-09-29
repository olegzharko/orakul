import { useSelector, useDispatch } from 'react-redux';
import { useHistory, useParams } from 'react-router-dom';
import { useState, useEffect, useCallback, useMemo } from 'react';
import { SelectItem } from '../../../../../../../../../../types';
import { State } from '../../../../../../../../../../store/types';
import getDevelopers from '../../../../../../../../../../services/generator/Developer/getDevelopers';
import reqRepresentative from '../../../../../../../../../../services/generator/Developer/reqRepresentative';
import { setModalInfo } from '../../../../../../../../../../store/main/actions';

type DeveloperCardData = {
  id: string;
  title: string;
  color: string;
  info: {
    title: string;
    value: string;
  }[]
}

type RepresentativeData = {
  title: string,
  value: string,
}

export const useDashboard = () => {
  const dispatch = useDispatch();
  const history = useHistory();

  const { id } = useParams<{ id: string }>();
  const { token } = useSelector((state: State) => state.main.user);

  const [developers, setDevelopers] = useState<DeveloperCardData[]>([]);
  const [isLoading, setLoading] = useState<boolean>(false);

  const [devRepresentative, setDevRepresentative] = useState<SelectItem[]>([]);
  const [selectedRepresentative, setSelectedRepresentative] = useState<any>();

  const [representative, setRepresentative] = useState<RepresentativeData[]>([]);
  const [representativeDoc, setRepresentativeDoc] = useState<RepresentativeData[]>([]);

  const onSave = useCallback(async () => {
    if (token) {
      const data = { dev_representative_id: selectedRepresentative };
      const res = await reqRepresentative(token, id, 'POST', data);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );
    }
  }, [token, selectedRepresentative, id, dispatch]);

  const onCardClick = useCallback((link: string) => {
    history.push(link);
  }, [history]);

  useEffect(() => {
    if (token) {
      // get DEVELOPERS
      (async () => {
        setLoading(true);

        const res = await getDevelopers(token, id);

        if (res?.success) {
          setDevelopers(res.data.dev_companies || []);
          setDevRepresentative(res.data.dev_representative || []);
          setSelectedRepresentative(res.data.representative_id);
          setRepresentative(res.data.representative_info || []);
          setRepresentativeDoc(res.data.representative_doc || []);
        }

        setLoading(false);
      })();
    }
  }, [token, id]);

  useEffect(() => {
    if (token && selectedRepresentative) {
      (async () => {
        const res = await reqRepresentative(token, selectedRepresentative);

        if (res?.success) {
          setRepresentative(res.data.representative_info);
          setRepresentativeDoc(res.data.representative_doc);
        }
      })();
    }
  }, [selectedRepresentative, token]);

  return {
    id,
    developers,
    isLoading,
    devRepresentative,
    representative,
    selectedRepresentative,
    representativeDoc,
    onCardClick,
    setSelectedRepresentative,
    onSave,
  };
};
