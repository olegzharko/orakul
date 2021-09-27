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
  const [notaries, setNotaries] = useState<ArchiveToolsNotary[][]>([]);

  const [totalPages, setTotalPages] = useState<number>(1);
  const [totalRaws, setTotalRaws] = useState<number>(0);

  const [selectedPage, setSelectedPage] = useState<number>(1);
  const [selectedNotary, setSelectedNotary] = useState<number>(0);
  const [filterSelectsData, setFilterSelectsData] = useState<ArchiveSelectsFilterData>({});
  const [period, setPeriod] = useState<ArchivePeriod>({});

  const [tableHeader, setTableHeader] = useState<ArchiveToolsTableHeader[]>([]);
  const [tableRawsData, setTableRawsData] = useState([]);

  const bodyData = useMemo(() => ({
    ...filterSelectsData,
    start_date: formatDate(period.start_date),
    final_date: formatDate(period.final_date),
    page: selectedPage,
  }), [filterSelectsData, period, selectedPage]);

  // Callbacks
  const onNotaryChange = useCallback(async (notaryId: number) => {
    if (!token) return;
    setSelectedNotary(notaryId);

    const res = await getArchiveTableData(token, notaryId, bodyData);

    setTableRawsData(res?.data);
    setTotalPages(res?.tools.last_page);
    setTotalRaws(res?.tools.total_items);
  }, [bodyData, token]);

  const onFilterChange = useCallback(async (newFilter: ArchiveSelectsFilterData) => {
    if (!token) return;
    setFilterSelectsData(newFilter);

    const res = await getArchiveTableData(
      token,
      selectedNotary,
      { ...bodyData, ...newFilter },
    );

    setTableRawsData(res?.data);
    setTotalPages(res?.tools.last_page);
    setTotalRaws(res?.tools.total_items);
  }, [bodyData, selectedNotary, token]);

  const onPageChange = useCallback(async (_, page: number) => {
    if (!token) return;
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
    setSelectedPage(page);

    const res = await getArchiveTableData(token, selectedNotary, { ...bodyData, page });

    setTableRawsData(res?.data);
    setTotalPages(res?.tools.last_page);
    setTotalRaws(res?.tools.total_items);
  }, [bodyData, selectedNotary, token]);

  const onPeriodChange = useCallback(async (newPeriod: ArchivePeriod) => {
    if (!token) return;
    setPeriod(newPeriod);

    const res = await getArchiveTableData(token, selectedNotary, {
      ...bodyData,
      start_date: formatDate(newPeriod.start_date),
      final_date: formatDate(newPeriod.final_date),
    });

    setTableRawsData(res?.data);
    setTotalPages(res?.tools.last_page);
    setTotalRaws(res?.tools.total_items);
  }, [bodyData, selectedNotary, token]);

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

  // Effects
  useEffect(() => {
    if (!token) return;

    getArchiveTools(token)
      .then((res) => {
        setNotaries(res?.notary || []);
        setTableHeader(res?.column || []);
        setSelectedNotary(res?.notary[0][0].id);

        return { notaryId: res?.notary[0][0].id, bodyData: { page: 1 } };
      })
      .then(async ({ notaryId, bodyData }) => {
        const res = await getArchiveTableData(token, notaryId, bodyData);
        setTableRawsData(res?.data);
        setTotalPages(res?.tools.last_page);
        setTotalRaws(res?.tools.total_items);
      })
      .catch((e:any) => {
        alert(e.message);
        console.error(e);
      })
      .finally(() => setIsLoading(false));
  }, [token]);

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
    onFilterChange,
    onPageChange,
    onPeriodChange,
  };
};
