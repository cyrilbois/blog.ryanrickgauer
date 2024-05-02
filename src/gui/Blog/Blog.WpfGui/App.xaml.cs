﻿// This Source Code Form is subject to the terms of the MIT License.
// If a copy of the MIT was not distributed with this file, You can obtain one at https://opensource.org/licenses/MIT.
// Copyright (C) Leszek Pomianowski and WPF UI Contributors.
// All Rights Reserved.

using Blog.Service.Domain.Configs;
using Blog.Service.Repository.Contracts;
using Blog.Service.Repository.Implementations;
using Blog.Service.Repository.Other;
using Blog.Service.Services.Contracts;
using Blog.Service.Services.Implementations;
using Blog.WpfGui.Services;
using Blog.WpfGui.ViewModels.Pages;
using Blog.WpfGui.ViewModels.Windows;
using Blog.WpfGui.Views.Pages;
using Blog.WpfGui.Views.Windows;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Hosting;
using System.IO;
using System.Reflection;
using System.Windows.Threading;
using Wpf.Ui;

namespace Blog.WpfGui;

/// <summary>
/// Interaction logic for App.xaml
/// </summary>
public partial class App
{
    // The.NET Generic Host provides dependency injection, configuration, logging, and other services.
    // https://docs.microsoft.com/dotnet/core/extensions/generic-host
    // https://docs.microsoft.com/dotnet/core/extensions/dependency-injection
    // https://docs.microsoft.com/dotnet/core/extensions/configuration
    // https://docs.microsoft.com/dotnet/core/extensions/logging
    private static readonly IHost _host = Host
        .CreateDefaultBuilder()
        .ConfigureAppConfiguration(c => { c.SetBasePath(Path.GetDirectoryName(Assembly.GetEntryAssembly()!.Location)); })
        .ConfigureServices((context, services) =>
        {

            #region - WpfUi stuff -
            services.AddHostedService<ApplicationHostService>();

            // Page resolver service
            services.AddSingleton<IPageService, PageService>();

            // Theme manipulation
            services.AddSingleton<IThemeService, ThemeService>();

            // TaskBar manipulation
            services.AddSingleton<ITaskBarService, TaskBarService>();

            services.AddSingleton<ISnackbarService, SnackbarService>();

            // Service containing navigation, same as INavigationWindow... but without window
            services.AddSingleton<INavigationService, NavigationService>();

            services.AddSingleton<IContentDialogService, ContentDialogService>();

            // Main window with navigation
            services.AddSingleton<INavigationWindow, MainWindow>();
            services.AddSingleton<MainWindowViewModel>();

            #endregion

            services.AddSingleton<LandingPage>();
            services.AddSingleton<LandingViewModel>();

            services.AddSingleton<SettingsPage>();
            services.AddSingleton<SettingsViewModel>();

            services.AddSingleton<EntriesPage>();
            services.AddSingleton<EntriesViewModel>();

            services.AddSingleton<EntryFormViewModel>();
            services.AddSingleton<EntryFormPage>();

            services.AddSingleton<TopicsViewModel>();
            services.AddSingleton<TopicsPage>();

            services.AddSingleton<TopicFormViewModel>();
            services.AddSingleton<TopicFormPage>();


            bool isDebug = false;

#if DEBUG
            isDebug = true;
#endif


            if (isDebug)
            {
                services.AddSingleton<IConfigs, ConfigurationDev>();
            }
            else
            {
                services.AddSingleton<IConfigs, ConfigurationProduction>();
            }

            services.AddScoped<IEntryService, EntryService>();
            services.AddScoped<ITopicService, TopicService>();
            services.AddSingleton<ITableMapperService, TableMapperService>();
            services.AddSingleton<IMarkdownService, MarkdownService>();

            services.AddScoped<IEntryRepository, EntryRepository>();
            services.AddScoped<ITopicRepository, TopicRepository>();

            services.AddTransient<DatabaseConnection>();



        }).Build();

    /// <summary>
    /// Gets registered service.
    /// </summary>
    /// <typeparam name="T">Type of the service to get.</typeparam>
    /// <returns>Instance of the service or <see langword="null"/>.</returns>
    public static T GetService<T>()
        where T : class
    {
        return _host.Services.GetService(typeof(T)) as T;
    }

    /// <summary>
    /// Occurs when the application is loading.
    /// </summary>
    private void OnStartup(object sender, StartupEventArgs e)
    {
        _host.Start();
    }

    /// <summary>
    /// Occurs when the application is closing.
    /// </summary>
    private async void OnExit(object sender, ExitEventArgs e)
    {
        await _host.StopAsync();

        _host.Dispose();
    }

    /// <summary>
    /// Occurs when an exception is thrown by an application but not handled.
    /// </summary>
    private void OnDispatcherUnhandledException(object sender, DispatcherUnhandledExceptionEventArgs e)
    {
        // For more info see https://docs.microsoft.com/en-us/dotnet/api/system.windows.application.dispatcherunhandledexception?view=windowsdesktop-6.0
    }
}
