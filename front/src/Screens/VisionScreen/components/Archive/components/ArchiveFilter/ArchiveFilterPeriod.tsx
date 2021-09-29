import React, { useCallback } from 'react';

import CustomDatePicker from '../../../../../../components/CustomDatePicker/CustomDatePicker';

import { ArchivePeriod } from '../../types';

type ArchiveFilterPeriodProps = {
  period: ArchivePeriod,
  onChange: (newPeriod: ArchivePeriod) => void,
}

const ArchiveFilterPeriod = ({ period, onChange }: ArchiveFilterPeriodProps) => {
  const onStartPeriodChange = useCallback((e) => {
    onChange({ ...period, start_date: e });
  }, [onChange, period]);

  const onFinalPeriodChange = useCallback((e) => {
    onChange({ ...period, final_date: e });
  }, [onChange, period]);

  return (
    <div className="period">
      <div className="period__picker">
        <CustomDatePicker
          label="Від"
          selectedDate={period.start_date}
          onSelect={onStartPeriodChange}
        />
      </div>
      <div className="period__picker">
        <CustomDatePicker
          label="По"
          selectedDate={period.final_date}
          onSelect={onFinalPeriodChange}
        />
      </div>
    </div>
  );
};

export default ArchiveFilterPeriod;
