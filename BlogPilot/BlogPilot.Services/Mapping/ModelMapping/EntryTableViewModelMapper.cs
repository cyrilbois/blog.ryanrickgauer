﻿using BlogPilot.Services.Domain.Model;
using BlogPilot.Services.Domain.TableViews;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BlogPilot.Services.Mapping.ModelMapping;

public class EntryTableViewModelMapper : ModelMapper<EntryTableView>
{
    
    public override EntryTableView ToModel(DataRow dataRow)
    {
        EntryTableView entry = new()
        {
            Id = GetSqlColumn<int?>(dataRow, nameof(EntryTableView.Id)),
            Title = GetSqlColumn<string?>(dataRow, nameof(EntryTableView.Title)),
            SourceLink = new(new(GetSqlColumn<string?>(dataRow, nameof(EntryTableView.SourceLink)))),
            Date = GetSqlColumn<DateTime?>(dataRow, nameof(EntryTableView.Date)),
            DateText = GetSqlColumn<string?>(dataRow, nameof(EntryTableView.DateText)),
            TopicId = GetSqlColumn<uint?>(dataRow, nameof(EntryTableView.TopicId)),
            TopicName = GetSqlColumn<string?>(dataRow, nameof(EntryTableView.TopicName)),
        };

        return entry;
    }
}
