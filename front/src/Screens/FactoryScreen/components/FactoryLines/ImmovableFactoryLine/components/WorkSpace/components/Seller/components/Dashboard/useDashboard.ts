import { useSelector, useDispatch } from 'react-redux';
import { useHistory, useParams } from 'react-router-dom';
import { useState, useEffect, useCallback, useMemo } from 'react';

import { SelectItem } from '../../../../../../../../../../../types';
import { State } from '../../../../../../../../../../../store/types';
import getDevelopers from '../../../../../../../../../../../services/generator/Developer/getDevelopers';
import reqRepresentative from '../../../../../../../../../../../services/generator/Developer/reqRepresentative';
import { setModalInfo } from '../../../../../../../../../../../store/main/actions';
import routes from '../../../../../../../../../../../routes';

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

  const { lineItemId } = useParams<{ lineItemId: string }>();
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
      const res = await reqRepresentative(token, lineItemId, 'POST', data);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );
    }
  }, [token, selectedRepresentative, lineItemId, dispatch]);

  const onCardClick = useCallback((link: string) => {
    history.push(link);
  }, [history]);

  const mappedDevelopers = useMemo(() => developers.map((developer) => ({
    ...developer,
    onClick: () => onCardClick(routes.factory.lines.immovable.sections.seller.developerView.linkTo(
      lineItemId, developer.id
    ))
  })), [developers, lineItemId, onCardClick]);

  useEffect(() => {
    if (token) {
      // get DEVELOPERS
      (async () => {
        setLoading(true);

        const res = await getDevelopers(token, lineItemId);

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
  }, [token, lineItemId]);

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
    lineItemId,
    mappedDevelopers,
    isLoading,
    devRepresentative,
    representative,
    selectedRepresentative,
    representativeDoc,
    setSelectedRepresentative,
    onSave,
  };
};
