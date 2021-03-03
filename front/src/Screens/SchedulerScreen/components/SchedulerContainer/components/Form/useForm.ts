/* eslint-disable arrow-body-style */
/* eslint-disable import/prefer-default-export */
import { useMemo, useState, useCallback } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { State } from '../../../../../../store/types';
import fetchDeveloperInfo from '../../../../../../actions/fetchDeveloperInfo';
import { setDevelopersInfo } from '../../../../../../store/scheduler/actions';

export const useForm = () => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.token);
  const { options, developersInfo, isLoading } = useSelector(
    (state: State) => state.scheduler
  );

  const [responseData, setResponseData] = useState({
    notary_id: null,
    dev_company_id: null,
    dev_representative_id: null,
    developer_manager_id: null,
  });

  const notaries = useMemo(() => options?.form_data.notary, [options]);
  const developers = useMemo(() => options?.form_data.developer, [options]);

  const manager = useMemo(() => developersInfo?.manager || [], [
    developersInfo,
  ]);

  const building = useMemo(() => developersInfo?.building || [], [
    developersInfo,
  ]);

  const representative = useMemo(() => developersInfo?.representative || [], [
    developersInfo,
  ]);

  const onNotaryChange = useCallback(
    (value) => {
      setResponseData({
        ...responseData,
        notary_id: value,
      });
    },
    [responseData]
  );

  const onDeveloperChange = useCallback(
    (value) => {
      setResponseData({
        ...responseData,
        dev_company_id: value,
      });

      if (!value) {
        dispatch(setDevelopersInfo({}));
      }

      if (token) {
        fetchDeveloperInfo(dispatch, token, value);
      }
    },
    [token, responseData]
  );

  const onRepresentativeChange = useCallback(
    (value) => {
      setResponseData({
        ...responseData,
        dev_representative_id: value,
      });
    },
    [responseData]
  );

  const onManagerChange = useCallback(
    (value) => {
      setResponseData({
        ...responseData,
        developer_manager_id: value,
      });
    },
    [responseData]
  );

  console.log(responseData);

  const shouldLoad = useMemo(() => isLoading || !options, [options, isLoading]);

  return {
    shouldLoad,
    notaries,
    representative,
    developers,
    manager,
    building,
    onNotaryChange,
    onDeveloperChange,
    onRepresentativeChange,
    onManagerChange,
  };
};
