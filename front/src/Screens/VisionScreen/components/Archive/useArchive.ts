import { useEffect, useMemo, useState, useCallback } from 'react';
import { useSelector } from 'react-redux';
import getArchiveTableData from '../../../../services/vision/archive/getArchiveTableData';

import getArchiveTools from '../../../../services/vision/archive/getArchiveTools';
import { State } from '../../../../store/types';
import { formatDate } from '../../../../utils/formatDates';

import { ArchivePeriod, ArchiveSelectsFilterData, ArchiveToolsNotary, ArchiveToolsTableHeader } from './types';
import { formatArchiveTableRawValue } from './utils';

export const useArchive = () => {
  const { token } = useSelector((state: State) => state.main.user);

  // State
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [filterLoadOn, setFilterLoadOn] = useState<boolean>(false);
  const [notaries, setNotaries] = useState<ArchiveToolsNotary[][]>([]);

  const [totalPages, setTotalPages] = useState<number>(1);
  const [totalRaws, setTotalRaws] = useState<number>(0);

  const [selectedPage, setSelectedPage] = useState<number>(1);
  const [selectedNotary, setSelectedNotary] = useState<number>(0);
  const [filterSelectsData, setFilterSelectsData] = useState<ArchiveSelectsFilterData>({});
  const [period, setPeriod] = useState<ArchivePeriod>({});

  const [tableHeader, setTableHeader] = useState<ArchiveToolsTableHeader[]>([]);
  const [tableRawsData, setTableRawsData] = useState([]);

  // Callbacks
  const onNotaryChange = useCallback(async (notaryId: number) => {
    if (!token) return;
    setSelectedNotary(notaryId);
  }, [token]);

  const onFilterChange = useCallback(async (newFilter: ArchiveSelectsFilterData) => {
    if (!token) return;
    setFilterSelectsData(newFilter);
  }, [token]);

  const onPageChange = useCallback(async (_, page: number) => {
    if (!token) return;
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
    setSelectedPage(page);
  }, [token]);

  const onPeriodChange = useCallback(async (newPeriod: ArchivePeriod) => {
    if (!token) return;
    setPeriod(newPeriod);
  }, [token]);

  // Memo
  const formattedNotaries = useMemo(() => notaries.map((notary) => ({
    ...notary[0],
    onClick: () => onNotaryChange(notary[0].id),
  })), [notaries, onNotaryChange]);

  const formattedTableRawsData = useMemo(() => tableRawsData.map(
    (raw) => tableHeader.map(
      ({ alias }) => formatArchiveTableRawValue(raw[alias])
    )
  ),
  [tableHeader, tableRawsData]);

  const isTableContentShow = useMemo(
    () => formattedTableRawsData.length > 0, [formattedTableRawsData.length]
  );

  // Effects
  useEffect(() => {
    if (!token) return;

    getArchiveTools(token)
      .then((res) => {
        setNotaries(res?.notary || []);
        setTableHeader(res?.column || []);
        setSelectedNotary(res?.notary[0][0].id);
        setFilterLoadOn(true);
      })
      .catch((e:any) => {
        alert(e.message);
        console.error(e);
      });
  }, [token]);

  useEffect(() => {
    if (!filterLoadOn || !token) return;

    (async () => {
      const bodyData = {
        ...filterSelectsData,
        start_date: formatDate(period.start_date),
        final_date: formatDate(period.final_date),
        page: selectedPage,
      };

      const res = await getArchiveTableData(token, selectedNotary, bodyData);
      setTableRawsData(res?.data);
      setTotalPages(res?.tools.last_page);
      setTotalRaws(res?.tools.total_items);
      setFilterLoadOn(true);
      setIsLoading(false);
    })();
  }, [
    filterLoadOn,
    filterSelectsData,
    period.final_date,
    period.start_date,
    selectedNotary,
    selectedPage,
    token,
  ]);

  return {
    isLoading,
    formattedNotaries,
    selectedNotary,
    tableHeader,
    filterSelectsData,
    totalPages,
    selectedPage,
    totalRaws,
    formattedTableRawsData,
    period,
    isTableContentShow,
    onFilterChange,
    onPageChange,
    onPeriodChange,
  };
};
